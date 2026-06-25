<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CreatorProfile;
use App\Models\Service;
use App\Models\Studio;
use App\Models\User;
use App\Notifications\BookingConfirmedNotification;
use App\Notifications\NewBookingNotification;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // In BookingController@index — replace the existing method with this:

    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->isClient()) {
            $bookings = $user->bookings()
                ->with(['service', 'creatorProfile.user', 'studio'])
                ->latest()
                ->paginate(15);

            return view('bookings.index', compact('bookings'));
        }

        // Creator — also pass $user, $profile, $studio so the topbar renders correctly
        $profile = $user->creatorProfile;
        $studio  = $profile?->studio ?? $user->ownedStudio ?? null;

        $bookings = Booking::where('creator_profile_id', $profile?->id)
            ->with(['client', 'service'])
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15);

        return view('bookings.index', compact('bookings', 'user', 'profile', 'studio'));
    }

    public function create(Request $request)
    {
        // Load the service with its serviceable (polymorphic)
        $service = Service::with('serviceable')->findOrFail($request->service_id);

        // Get the serviceable model (Studio or CreatorProfile)
        $serviceable = $service->serviceable;

        // Determine the owner/user based on the type
        if ($serviceable instanceof CreatorProfile) {
            // For CreatorProfile, load the user relationship
            $serviceable->load('user');
            $owner = $serviceable->user;
        } elseif ($serviceable instanceof Studio) {
            // For Studio, load the owner relationship
            $serviceable->load('owner');
            $owner = $serviceable->owner;
        } else {
            $owner = null;
        }

        return view('bookings.create', compact('service', 'serviceable', 'owner'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id'       => 'required|exists:services,id',
            'event_date'       => 'required|date|after:today',
            'start_time'       => 'nullable|date_format:H:i',
            'end_time'         => 'nullable|date_format:H:i|after:start_time',
            'event_type'       => 'nullable|string|max:100',
            'venue'            => 'nullable|string|max:500',
            'notes'            => 'nullable|string|max:2000',
            'special_requests' => 'nullable|string|max:2000',
        ]);

        $service     = Service::findOrFail($request->service_id);
        $serviceable = $service->serviceable;

        // Determine which column to check for conflicts
        $column    = $serviceable instanceof CreatorProfile ? 'creator_profile_id' : 'studio_id';
        $conflicts = Booking::where($column, $serviceable->id)
            ->where('event_date', $request->event_date)
            ->whereNotIn('status', ['cancelled', 'refunded'])
            ->exists();

        if ($conflicts) {
            return back()->withErrors([
                'event_date' => 'This date is not available. Please choose another date.',
            ]);
        }

        $booking = Booking::create([
            'client_id'          => auth()->id(),
            'service_id'         => $service->id,
            'creator_profile_id' => $serviceable instanceof CreatorProfile ? $serviceable->id : null,
            'studio_id'          => $serviceable instanceof Studio ? $serviceable->id : null,
            'event_date'         => $request->event_date,
            'start_time'         => $request->start_time,
            'end_time'           => $request->end_time,
            'event_type'         => $request->event_type,
            'venue'              => $request->venue,
            'notes'              => $request->notes,
            'special_requests'   => $request->special_requests,
            'subtotal'           => $service->price,
            'total_amount'       => $service->price,
            'deposit_amount'     => $service->deposit_amount,
            'amount_paid'        => 0,
            'amount_due'         => $service->price,
        ]);

        // Notify the creator or studio owner
        if ($serviceable instanceof CreatorProfile) {
            $creatorUser = $serviceable->user;
        } elseif ($serviceable instanceof Studio) {
            $creatorUser = $serviceable->owner;
        } else {
            $creatorUser = null;
        }

        if ($creatorUser) {
            $creatorUser->notify(new NewBookingNotification($booking));
        }

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking request sent!');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        $booking->load(['client', 'service', 'creatorProfile.user', 'studio', 'payments', 'review']);

        return view('bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        $this->authorize('update', $booking);

        $booking->update([
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        $booking->client->notify(new BookingConfirmedNotification($booking));

        return back()->with('success', 'Booking confirmed!');
    }

    public function cancel(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $request->validate(['reason' => 'nullable|string|max:1000']);

        $booking->update([
            'status'              => 'cancelled',
            'cancelled_at'        => now(),
            'cancellation_reason' => $request->reason,
        ]);

        return back()->with('success', 'Booking cancelled.');
    }

    public function accept(Booking $booking)
    {
        $this->authorize('update', $booking);
        $booking->update(['status' => 'confirmed']);
        return back()->with('success', 'Booking confirmed.');
    }

    public function decline(Booking $booking)
    {
        $this->authorize('update', $booking);
        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking declined.');
    }
}

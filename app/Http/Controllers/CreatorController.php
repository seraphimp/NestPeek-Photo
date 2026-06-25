<?php

namespace App\Http\Controllers;

use App\Models\CreatorProfile;
use App\Models\Favorite;
use Illuminate\Http\Request;

class CreatorController extends Controller
{
    public function index(Request $request)
    {
        $query = CreatorProfile::with('user')
            ->withCount(['bookings', 'reviews'])   // ← both counts in one query, no N+1
            ->where('is_available', true)
            ->whereHas('user', fn($q) => $q->where('is_active', true));

        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }
        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->whereJsonContains('service_areas', $request->location)
                    ->orWhereHas('user', fn($q2) => $q2->where('location', 'like', "%{$request->location}%"));
            });
        }
        if ($request->filled('min_price'))  $query->where('starting_price', '>=', $request->min_price);
        if ($request->filled('max_price'))  $query->where('starting_price', '<=', $request->max_price);
        if ($request->filled('style'))      $query->whereJsonContains('styles', $request->style);
        if ($request->filled('min_rating')) $query->where('average_rating', '>=', $request->min_rating);
        if ($request->filled('availability')) $query->where('availability_status', $request->availability);

        match ($request->get('sort', 'featured')) {
            'rating'     => $query->orderByDesc('average_rating'),
            'price_asc'  => $query->orderBy('starting_price'),
            'price_desc' => $query->orderByDesc('starting_price'),
            'bookings'   => $query->orderByDesc('bookings_count'),  // ← real column now
            default      => $query->orderByDesc('average_rating'),
        };

        $creators = $query->paginate(12)->withQueryString();

        $specializations = [
            'wedding_photographer',
            'wedding_videographer',
            'portrait_photographer',
            'event_photographer',
            'event_videographer',
            'wedding_coordinator',
            'photo_editor',
            'video_editor',
            'drone_operator',
            'photo_booth',
        ];

        return view('creators.index', compact('creators', 'specializations'));
    }

    public function show(CreatorProfile $creatorProfile)
    {
        $creatorProfile->increment('profile_views');

        $creatorProfile->load([
            'user',
            'services'   => fn($q) => $q->where('is_active', true)->orderBy('sort_order'),
            'portfolios' => fn($q) => $q->where('is_published', true)->with('media')->orderBy('sort_order'),
            'reviews'    => fn($q) => $q->where('is_published', true)->with('reviewer')->latest()->limit(10),
            'studios',
        ]);

        // Only clients can favorite or leave reviews
        $isClient    = auth()->check() && auth()->user()->isClient();
        $isFavorited = $isClient
            ? Favorite::where('user_id', auth()->id())
            ->where('favorable_type', CreatorProfile::class)
            ->where('favorable_id', $creatorProfile->id)
            ->exists()
            : false;

        // Find a completed booking this client has with this creator (needed for review eligibility)
        $completedBooking = $isClient
            ? auth()->user()->bookings()
            ->where('creator_profile_id', $creatorProfile->id)
            ->where('status', 'completed')
            ->whereDoesntHave('review')   // hasn't reviewed yet
            ->latest()
            ->first()
            : null;

        return view('creators.Show', compact(
            'creatorProfile',
            'isFavorited',
            'isClient',
            'completedBooking'
        ));
    }

    public function edit()
    {
        $profile = auth()->user()
            ->creatorProfile()
            ->with(['services', 'portfolios'])
            ->firstOrFail();

        return view('creators.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'brand_name'        => 'nullable|string|max:255',
            'tagline'           => 'nullable|string|max:255',
            'specialization'    => 'required|string',
            'skills'            => 'nullable|array',
            'equipment'         => 'nullable|array',
            'styles'            => 'nullable|array',
            'service_areas'     => 'nullable|array',
            'years_experience'  => 'nullable|integer',
            'starting_price'    => 'nullable|numeric',
            'availability_note' => 'nullable|string|max:500',
            'bio'               => 'nullable|string|max:5000',
            'location'          => 'nullable|string|max:255',
            'instagram'         => 'nullable|string|max:255',
            'facebook'          => 'nullable|string|max:255',
            'website'           => 'nullable|string|max:255',
        ]);

        $profile = auth()->user()->creatorProfile;
        $profile->update($request->only([
            'brand_name',
            'tagline',
            'specialization',
            'skills',
            'equipment',
            'styles',
            'service_areas',
            'years_experience',
            'starting_price',
            'availability_note',
        ]));

        if ($request->hasFile('cover_photo')) {
            $profile->update(['cover_photo' => $request->file('cover_photo')->store('covers', 'public')]);
        }

        auth()->user()->update($request->only(['bio', 'location', 'instagram', 'facebook', 'website']));

        if ($request->hasFile('avatar')) {
            auth()->user()->update(['avatar' => $request->file('avatar')->store('avatars', 'public')]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }
}

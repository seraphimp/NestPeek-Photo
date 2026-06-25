<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\StudioCreator;
use App\Models\Studio;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isCreator() || $user->isStudioOwner()) {
            $profile = $user->creatorProfile()->with([
                'bookings'   => fn($q) => $q->latest()->limit(5),
                'reviews'    => fn($q) => $q->latest()->limit(5),
                'portfolios' => fn($q) => $q->where('is_published', true),
            ])->first();

            $stats = [
                'total_bookings'     => $profile?->bookings()->count() ?? 0,
                'pending_bookings'   => $profile?->bookings()->where('status', 'pending')->count() ?? 0,
                'completed_bookings' => $profile?->bookings()->where('status', 'completed')->count() ?? 0,
                'total_revenue'      => $profile?->bookings()->where('status', 'completed')->sum('amount_paid') ?? 0,
                'average_rating'     => $profile?->average_rating ?? 0,
                'profile_views'      => $profile?->profile_views ?? 0,
                'portfolio_count'    => $profile?->portfolios()->count() ?? 0,
            ];

            // ================================================================
            // FIXED: Get studio - check BOTH owner AND member
            // ================================================================
            $studio = null;

            // Check if user OWNS a studio
            if ($user->ownedStudios()->exists()) {
                $studio = $user->ownedStudios()->with('creators')->first();
            }
            // If not owner, check if user is a MEMBER through studio_creators table
            else {
                // Direct query using creator_id (matches your migration)
                $studioCreator = StudioCreator::where('creator_id', $user->id)
                    ->with('studio.creators')
                    ->first();
                
                if ($studioCreator) {
                    $studio = $studioCreator->studio;
                }
            }

            return view('dashboard.creator', compact('user', 'profile', 'stats', 'studio'));
        }

        // Client dashboard
        $bookings = $user->bookings()
            ->with(['service', 'creatorProfile.user', 'studio'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total_bookings'     => $user->bookings()->count(),
            'upcoming_bookings'  => $user->bookings()
                ->where('event_date', '>=', now())
                ->where('status', '!=', 'cancelled')
                ->count(),
            'completed_bookings' => $user->bookings()->where('status', 'completed')->count(),
        ];

        return view('dashboard.client', compact('user', 'bookings', 'stats'));
    }
}

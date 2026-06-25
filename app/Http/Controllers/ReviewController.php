<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    public function store(Request $request, Booking $booking)
    {
        $this->authorize('view', $booking); // client must own this booking

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title'  => 'nullable|string|max:255',
            'body'   => 'required|string|min:10|max:2000',
        ]);

        // Prevent duplicate reviews
        if ($booking->review()->exists()) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        $review = $booking->review()->create([
            'reviewer_id'     => auth()->id(),
            'reviewable_type' => CreatorProfile::class,
            'reviewable_id'   => $booking->creator_profile_id,
            'rating'          => $request->rating,
            'title'           => $request->title,
            'body'            => $request->body,
            'content'         => $request->body, // in case your column is 'content'
            'is_published'    => true,
        ]);

        // Keep cached stats in sync
        $booking->creatorProfile?->syncReviewStats();

        return back()->with('success', 'Thank you for your review!');
    }
}

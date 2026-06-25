<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        // Allow the client who made the booking
        if ($user->id === $booking->client_id) {
            return true;
        }

        // Allow the creator who owns the booking
        if ($booking->creator_profile_id && $user->creatorProfile?->id === $booking->creator_profile_id) {
            return true;
        }

        // Allow the studio owner
        if ($booking->studio_id) {
            // Check if the user owns this studio
            $studio = \App\Models\Studio::find($booking->studio_id);
            if ($studio && $studio->owner_id === $user->id) {
                return true;
            }
        }

        return false;
    }

    public function update(User $user, Booking $booking): bool
    {
        // Only the creator/studio owner can confirm or cancel
        if ($booking->creator_profile_id && $user->creatorProfile?->id === $booking->creator_profile_id) {
            return true;
        }

        // Check if user owns the studio
        if ($booking->studio_id) {
            $studio = \App\Models\Studio::find($booking->studio_id);
            if ($studio && $studio->owner_id === $user->id) {
                return true;
            }
        }

        // Allow the client to cancel their own booking
        if ($user->id === $booking->client_id) {
            return true;
        }

        return false;
    }

    public function accept(User $user, Booking $booking): bool
    {
        // Only creator or studio owner can accept
        if ($booking->creator_profile_id && $user->creatorProfile?->id === $booking->creator_profile_id) {
            return true;
        }

        if ($booking->studio_id) {
            $studio = \App\Models\Studio::find($booking->studio_id);
            if ($studio && $studio->owner_id === $user->id) {
                return true;
            }
        }

        return false;
    }

    public function decline(User $user, Booking $booking): bool
    {
        // Same as accept - only creator or studio owner can decline
        return $this->accept($user, $booking);
    }

    public function cancel(User $user, Booking $booking): bool
    {
        // Allow client to cancel, or creator/studio owner to cancel
        if ($user->id === $booking->client_id) {
            return true;
        }

        if ($booking->creator_profile_id && $user->creatorProfile?->id === $booking->creator_profile_id) {
            return true;
        }

        if ($booking->studio_id) {
            $studio = \App\Models\Studio::find($booking->studio_id);
            if ($studio && $studio->owner_id === $user->id) {
                return true;
            }
        }

        return false;
    }
}

<?php

namespace App\Policies;

use App\Models\Studio;
use App\Models\User;

class StudioPolicy
{
    public function update(User $user, Studio $studio): bool
    {
        return $user->id === $studio->owner_id;
    }

    public function delete(User $user, Studio $studio): bool
    {
        return $user->id === $studio->owner_id;
    }
}

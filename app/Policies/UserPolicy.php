<?php

namespace App\Policies;

use App\Models\User;
use App\Models\User;

class UserPolicy extends Policy
{
    public function update(User $user, User $user)
    {
        return $user->id == $user->id or $user->type >= 4;
    }

    public function destroy(User $user, User $user)
    {
        return $user->type >= 4;
    }
}

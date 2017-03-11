<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wiki;

class WikiPolicy extends Policy
{
    public function before(User $user)
    {
        if ($user->status > 0) {
            return true;
        }
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Wiki $wiki)
    {
        return true;
    }

    public function destroy(User $user, Wiki $wiki)
    {
        return $user->type >= 3;
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wiki;

class WikiPolicy extends Policy
{
    public function create(User $user)
    {
        return $user->status > 0;
    }

    public function update(User $user, Wiki $wiki)
    {
        return $user->status > 0;
    }

    public function destroy(User $user, Wiki $wiki)
    {
        return $user->type >= 3;
    }
}

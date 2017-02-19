<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wiki;

class WikiPolicy extends Policy
{
    public function update(User $user, Wiki $wiki)
    {
        // return $wiki->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Wiki $wiki)
    {
        return true;
    }
}

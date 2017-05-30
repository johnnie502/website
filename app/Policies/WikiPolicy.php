<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wiki;
use Illuminate\Auth\Access\HandlesAuthorization;

class WikiPolicy extends Policy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        // Does this user is loginned?
        if ($user->status <= 0) {
            return false;
        }
        return (Auth::check()) ? true : null;
    }

    /**
     * Determine whether the user can view the wiki.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Wiki  $wiki
     * @return mixed
     */
    public function view(User $user, Wiki $wiki)
    {
        return true;
    }

    /**
     * Determine whether the user can create wikis.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the wiki.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Wiki  $wiki
     * @return mixed
     */
    public function update(User $user, Wiki $wiki)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the wiki.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Wiki  $wiki
     * @return mixed
     */
    public function delete(User $user, Wiki $wiki)
    {
        return $user->type >= 3;
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends Policy
{
	use HandlesAuthorization;

    /**
     * Determine whether current user can view the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $account
     * @return mixed
     */
    public function view(User $account, User $user)
    {
        if (isset($user)) {
            return $user->status >= 0;
        }
        return true;
    }

    /**
     * Determine whether the user can create account.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->status > 0;
    }

    /**
     * Determine whether the user can update self or other user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $account
     * @return mixed
     */
    public function update(User $account, User $user)
    {
        return $account->id == $user->id or $account->type >= 3;
    }

    /**
     * Determine whether the user can delete other user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $account
     * @return mixed
     */
    public function destroy(User $account, User $user)
    {
        return $account->type >= 3;
    }

    /**
     * Determine whether the user can follow other user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $follow
     * @return mixed
     */
    public function follow(User $user, User $follow)
    {
        return $user->status > 0;
    }
}

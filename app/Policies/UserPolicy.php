<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends Policy
{
	use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->status > 0) {
            return true;
        }
    }

    /**
     * Determine whether current user can view the user.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $account
     * @return mixed
     */
    public function view(User $user, User $account)
    {
        return true;
    }

    /**
     * Determine whether the user can create account.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $account)
    {
        return true;
    }

    public function update(User $user, User $account)
    {
        return $account->id == $user->id or $account->type >= 3;
    }

    public function destroy(User $user, User $account)
    {
        return $account->type >= 3;
    }
}

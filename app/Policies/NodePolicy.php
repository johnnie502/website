<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Node;
use Illuminate\Auth\Access\HandlesAuthorization;

class NodePolicy extends Policy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        // Does this user is loginned?
        if ($user->status <= 0) {
            return false;
        }
        return ($user->type >= 4) ? true : false;
    }

    /**
     * Determine whether the user can view the node.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Node  $node
     * @return mixed
     */
    public function view(User $user, Node $node)
    {
        return true;
    }

    /**
     * Determine whether the user can create nodes.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->type >= 4;
    }

    /**
     * Determine whether the user can update the node.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Node  $node
     * @return mixed
     */
    public function update(User $user, Node $node)
    {
        return $user->type >= 4;
    }

    /**
     * Determine whether the user can delete the node.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Node  $node
     * @return mixed
     */
    public function delete(User $user, Node $node)
    {
        return $user->type >= 4;
    }
}

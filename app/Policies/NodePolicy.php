<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Node;

class NodePolicy extends Policy
{
    public function before($user, $ability)
    {
        if ($user->status > 0) {
            return true;
        }
    }

    public function create(User $user)
    {
        return $user->type >= 4;
    }

    public function update(User $user, Node $node)
    {
        return $user->type >= 4;
    }

    public function destroy(User $user, Node $node)
    {
        return $user->type >= 4;
    }
}

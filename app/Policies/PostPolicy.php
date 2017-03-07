<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

class PostPolicy extends Policy
{
    public function create(User $user)
    {
        return $user->status > 0;
    }

    public function update(User $user, Post $post)
    {
        return $user->status > 0 && ($post->user == $user->id or $user->type >= 3);
    }

    public function destroy(User $user, Post $post)
    {
        return $user->type >= 3;
    }
}

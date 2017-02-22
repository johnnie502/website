<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

class PostPolicy extends Policy
{
    public function update(User $user, Post $post)
    {
        return $post->user == $user->id or $user->type >= 3;
    }

    public function destroy(User $user, Post $post)
    {
        return $user->type >= 3;
    }
}

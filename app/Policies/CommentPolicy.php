<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

class CommentPolicy extends Policy
{
    public function update(User $user, Comment $comment)
    {
        return $comment->user == $user->id or $user->type >= 3;
    }

    public function destroy(User $user, Comment $comment)
    {
        return $user->type >= 3;
    }
}

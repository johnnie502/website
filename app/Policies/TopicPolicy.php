<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function create(User $user)
    {
        return $user->status > 0;
    }

    public function update(User $user, Topic $topic)
    {
        return $user->status > 0 && ($topic->user == $user->id or $user->type >= 3);
    }

    public function destroy(User $user, Topic $topic)
    {
        return $user->type >= 3;
    }
}

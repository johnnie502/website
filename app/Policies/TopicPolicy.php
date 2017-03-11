<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function before(User $user)
    {
        if ($user->status > 0) {
            return true;
        }
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Topic $topic)
    {
        return $topic->user == $user->id or $user->type >= 3;
    }

    public function destroy(User $user, Topic $topic)
    {
        return $user->type >= 3;
    }
}

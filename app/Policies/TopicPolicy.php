<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
        return $topic->user == $user->id or $user->type >= 4;
    }

    public function destroy(User $user, Topic $topic)
    {
        return $user->type >= 4;
    }
}

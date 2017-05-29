<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy extends Policy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->status > 0) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the topic.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Topic  $topic
     * @return mixed
     */
    public function view(User $user, Topic $topic)
    {
        return true;
    }

    /**
     * Determine whether the user can create topics.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the topic.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Topic  $topic
     * @return mixed
     */
    public function update(User $user, Topic $topic)
    {
        return $topic->user == $user->id or $user->type >= 3;
    }

    /**
     * Determine whether the user can delete the topic.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Topic  $topic
     * @return mixed
     */
    public function delete(User $user, Topic $topic)
    {
        return $user->type >= 3;
    }

    /**
     * Determine whether the user can vote the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Topic  $topic
     * @return mixed
     */
    public function vote(User $user, Topic $topic)
    {
        return true;
    }
}
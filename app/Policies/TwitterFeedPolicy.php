<?php

namespace App\Policies;

use App\TwitterFeed;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TwitterFeedPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can vote the news.
     *
     * @param User    $user
     * @param TwitterFeed $feed
     *
     * @return bool
     */
    public function vote(User $user, TwitterFeed $feed)
    {
        return true;
    }
}

<?php

namespace App\Traits;

use App\User;

trait Ownable
{
    /**
     * Check if the model is owned by an user.
     *
     * @param User|int $user
     *
     * @return bool
     */
    public function isOwnedBy($user) : bool
    {
        return ($user instanceof User ? $user->id : $user) == $this->user_id;
    }

    /**
     * Model is created by an user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
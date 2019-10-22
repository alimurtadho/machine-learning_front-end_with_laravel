<?php

namespace App\Traits;

use App\Vote;
use Illuminate\Database\Eloquent\Model;

trait Votable
{
    /**
     * Boot the model.
     */
    protected static function boot ()
    {
        parent::boot();
        static::addGlobalScope('votesCount', function ($builder) {
            return $builder->withCount('votes');
        });
    }

    /**
     * A model can be voted.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    /**
     * Vote the current model.
     *
     * @return Model
     */
    public function vote()
    {
        $attributes = ['user_id' => auth()->id()];

        if (! $this->votes()->where($attributes)->exists()) {
            return $this->votes()->create($attributes);
        }
    }

    /**
     * Un-Vote the current model.
     *
     * @return Model
     */
    public function abstain()
    {
        $attributes = ['user_id' => auth()->id()];

        if ($vote = $this->votes()->where($attributes)->first()) {
            return $vote->delete();
        }
    }

    public function isVoted()
    {
        return $this->votes()->where('user_id', '=', auth()->id())->exists();
    }
}
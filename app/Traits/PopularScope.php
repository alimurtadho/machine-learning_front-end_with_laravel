<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait PopularScope
{
    /**
     * Scope for trending news.
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopeTrending(Builder $query)
    {
        return $query->where('created_at', '>', Carbon::parse('-7  days'))
                     ->orderByDesc($this->popularity_field ?? 'votes_count');
    }

    /**
     * Scope for popular news.
     *
     * @param Builder $query
     *
     * @return mixed
     */
    public function scopePopular(Builder $query)
    {
        return $query->orderByDesc($this->popularity_field ?? 'votes_count');
    }
}
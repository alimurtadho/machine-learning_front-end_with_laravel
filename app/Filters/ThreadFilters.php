<?php

namespace App\Filters;

use DB;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ThreadFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     * @var array
     */
    protected $filters = ['author', 'contributor', 'trending', 'popular', 'answered', 'search'];

    /**
     * Filter threads by contributor.
     *
     * @param $username
     *
     * @return Builder
     */
    public function contributor ($username)
    {
        $id = User::findByUsername($username, ['id'])->id ?? null;

        return $id ? $this->builder->where('user_id', '=', $id)
                                   ->orWhereHas('replies',
                                       function ($query) use ($id) {
                                           $query->whereUserId($id);
                                       }) : $this->builder;
    }

    /**
     * Filter threads by whether they are answered.
     *
     * @param $value
     *
     * @return Builder
     */
    public function answered ($value)
    {
        return $value == 'true' ? $this->builder->answered() : $this->builder->answered(false);
    }

    /**
     * Filter thread by search query.
     *
     * @param $query
     *
     * @return Builder
     */
    public function search($query)
    {
        $keywords = array_filter(explode(' ', $query));

        return $this->builder->where(function($query) use($keywords) {
            foreach($keywords as $word){
                $query->orWhere(DB::raw('lower(name)'), 'like', '%'.strtolower($word).'%');
                $query->orWhere(DB::raw('lower(body)'), 'like', '%'.strtolower($word).'%');
            }
        });
    }
}
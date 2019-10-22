<?php

namespace App\Filters;

use DB;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class CodeFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['author', 'search', 'trending', 'popular'];

    /**
     * Filter code by user.
     *
     * @param $username
     *
     * @return Builder
     */
    public function author($username)
    {
        $id = User::findByUsername($username, ['id'])->id ?? null;
        return $id ? $this->builder->whereUserId($id) : $this->builder;
    }

    /**
     * Filter code by search query.
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
            }
        });
    }
}
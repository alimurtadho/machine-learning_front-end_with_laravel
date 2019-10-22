<?php

namespace App\Filters;

use DB;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class DatasetFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['featured', 'author', 'search', 'trending', 'popular'];

    /**
     * Filter dataset by search query.
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
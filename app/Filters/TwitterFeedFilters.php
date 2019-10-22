<?php

namespace App\Filters;

class TwitterFeedFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [ 'medicine', 'popular', 'trending' ];

    public function medicine ($value)
    {
        return $this->builder->whereMedicineRelated(true);
    }
}
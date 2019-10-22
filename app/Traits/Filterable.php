<?php

namespace App\Traits;

use App\Filters\Filters;

trait Filterable
{
    public function scopeFilter($query, Filters $filter)
    {
        return $filter->apply($query);
    }
}
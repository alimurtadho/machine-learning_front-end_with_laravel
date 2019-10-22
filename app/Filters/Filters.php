<?php

namespace App\Filters;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * The Eloquent builder.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Create a new ThreadFilters instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters.
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Fetch all relevant filters from the request.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->request->intersect($this->filters);
    }

    /**
     * Filter datasets by user.
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
     * Show only featured datasets.
     *
     * @param $value
     *
     * @return Builder
     */
    public function featured($value)
    {
        return $this->builder->featured();
    }

    /**
     * Order codes by popularity.
     *
     * @param $value
     *
     * @return Builder
     */
    public function popular ($value)
    {
        return $this->builder->popular();
    }

    /**
     * Trending codes this week.
     *
     * @param $value
     *
     * @return Builder
     */
    public function trending ($value)
    {
        return $this->builder->trending();
    }
}
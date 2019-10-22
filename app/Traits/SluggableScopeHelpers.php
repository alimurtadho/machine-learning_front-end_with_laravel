<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SluggableScopeHelpers
{

    /**
     * Primary slug column of this model.
     *
     * @return string
     */
    public function getSlugKeyName()
    {
        if (property_exists($this, 'slugKeyName')) {
            return $this->slugKeyName;
        }

        $config = $this->sluggable();
        $name = reset($config);
        $key = key($config);

        // check for short configuration
        if ($key === 0) {
            return $name;
        }

        return $key;
    }

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->getSlugKeyName();
    }

    /**
     * Primary slug value of this model.
     *
     * @return string
     */
    public function getSlugKey()
    {
        return $this->getAttribute($this->getSlugKeyName());
    }

    /**
     * Query scope for finding a model by its primary slug.
     *
     * @param Builder $scope
     * @param string  $slug
     *
     * @return Builder
     */
    public function scopeWhereSlug(Builder $scope, $slug)
    {
        return $scope->where($this->getSlugKeyName(), $slug);
    }

    /**
     * Find a model by its primary slug.
     *
     * @param Builder $query
     * @param string  $slug
     * @param array   $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public static function scopeFindBySlug(Builder $query, $slug, array $columns = ['*'])
    {
        return $query->whereSlug($slug)->first($columns);
    }

    /**
     * Find a model by its primary slug or throw an exception.
     *
     * @param Builder $query
     * @param string  $slug
     * @param array   $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public static function scopeFindBySlugOrFail(Builder $query, $slug, array $columns = ['*'])
    {
        return $query->whereSlug($slug)->firstOrFail($columns);
    }

    /**
     * Return the sluggable configuration array for this model.
     * @return array
     */
    public function sluggable ()
    {
        return [
            'slug' => ['source' => 'name']
        ];
    }
}

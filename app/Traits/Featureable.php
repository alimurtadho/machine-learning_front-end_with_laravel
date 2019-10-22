<?php

namespace App\Traits;

trait Featureable
{
    public function scopeFeatured($query, $condition = true)
    {
        return $query->whereFeatured($condition);
    }

    /**
     * Whether or not the item is featured.
     *
     * @return boolean
     */
    public function isFeatured ()
    {
        return $this->featured;
    }

    /**
     * Whether or not the item is not-featured.
     *
     * @return boolean
     */
    public function isNotFeatured ()
    {
        return !$this->featured;
    }

    /**
     * Feature the model.
     *
     * @return $this
     */
    public function feature ()
    {
        return $this->update(['featured' => true]);
    }

    /**
     * Un-feature the model.
     * @return $this
     */
    public function unFeature ()
    {
        return $this->update(['featured' => false]);
    }
}
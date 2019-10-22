<?php

namespace App;

use App\Traits\Filterable;
use App\Traits\Ownable;
use App\Traits\PopularScope;
use App\Traits\Publishable;
use App\Traits\SluggableScopeHelpers;
use App\Traits\Votable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use Sluggable, SluggableScopeHelpers;
    use Ownable, Publishable, Filterable, Votable, PopularScope;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Code must belong to a dataset.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dataset ()
    {
        return $this->belongsTo(Dataset::class);
    }

    /**
     * Get a string path for the code.
     *
     * @return string
     */
    public function path ()
    {
        return "/c/{$this->slug}";
    }
}

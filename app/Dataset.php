<?php

namespace App;

use App\Traits\Featureable;
use App\Traits\Filterable;
use App\Traits\Ownable;
use App\Traits\PopularScope;
use App\Traits\Publishable;
use App\Traits\SluggableScopeHelpers;
use App\Traits\Votable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Dataset extends Model implements HasMedia, HasMediaConversions
{
    use Sluggable, SluggableScopeHelpers, HasMediaTrait;
    use Ownable, Featureable, Publishable, Filterable, Votable, PopularScope;

    /**
     * The attributes that are not mass assignable.
     * @var array
     */
    protected $guarded = [];

    /**
     * Register the conversions that should be performed.
     */
    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_TOP_LEFT, 134, 134)
            ->format(Manipulations::FORMAT_PNG)
            ->performOnCollections('default');

        $this->addMediaConversion('big')
            ->crop(Manipulations::CROP_TOP_LEFT, 240, 240)
            ->format(Manipulations::FORMAT_PNG)
            ->performOnCollections('default');
    }


    /**
     * A thread may have many codes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function path()
    {
        return "/d/{$this->slug}";
    }
}
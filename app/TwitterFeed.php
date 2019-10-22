<?php

namespace App;

use App\Traits\Filterable;
use App\Traits\PopularScope;
use App\Traits\Votable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class TwitterFeed extends Model
{
    use Filterable, Searchable, Votable, PopularScope;

    protected $guarded = [];

    protected $hidden = ['data'];

    protected $dates = ['twitter_timestamp'];

    protected $casts = [
        'tags' => 'array',
    ];

    public static function search(string $query, $callback = null)
    {
        static::$globalScopes = [];

        $results = (new \Laravel\Scout\Builder(new static(), $query, $callback));

        return $results;
    }

    /**
     * @return array
     */
    public function toSearchableArray()
    {
        return array_only($this->toArray(), ['id', 'body', 'tags']);
    }

    /**
     * Get a string path for the news.
     *
     * @return string
     */
    public function path ()
    {
        return "/news/{$this->id}";
    }
}

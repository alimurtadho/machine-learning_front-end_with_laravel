<?php

namespace App;

use App\Traits\Filterable;
use App\Traits\Ownable;
use App\Traits\PopularScope;
use App\Traits\SluggableScopeHelpers;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use Sluggable, SluggableScopeHelpers;
    use Ownable, Filterable, PopularScope;

    protected $popularity_field = 'replies_count';

    /**
     * The attributes that are not mass assignable.
     * @var array
     */
    protected $guarded = [];

    /**
     * Boot the model.
     */
    protected static function boot ()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function ($builder) {
            return $builder->withCount('replies');
        });
    }

    /**
     * Scope for answered and unanswered threads.
     *
     * @param Builder $query
     * @param bool    $value
     *
     * @return Builder
     */
    public function scopeAnswered (Builder $query, $value = true)
    {
        return $query->where('answered', '=', $value);
    }

    /**
     * A thread belongs to a category.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category ()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * A thread may have many replies.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies ()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Add a reply to the thread.
     *
     * @param array $reply
     *
     * @return Model
     */
    public function addReply (array $reply)
    {
        return $this->replies()->create($reply);
    }

    /**
     * Add a reply to the thread.
     *
     * @param Reply $reply
     */
    public function selectBestReply (Reply $reply)
    {
        if ($reply->thread_id != $this->id) {
            return;
        }

        $this->update(['answered' => true]);
        $reply->update(['best_answer' => true]);
    }

    /**
     * Whether or not the thread is answered.
     *
     * @return bool
     */
    public function isAnswered()
    {
        return $this->answered;
    }

    /**
     * Whether or not the thread is not-answered.
     *
     * @return bool
     */
    public function isNotAnswered()
    {
        return !$this->answered;
    }

    /**
     * Get a string path for the thread.
     * @return string
     */
    public function path ()
    {
        return "/t/{$this->category->slug}/{$this->slug}";
    }
}

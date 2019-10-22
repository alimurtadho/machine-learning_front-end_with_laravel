<?php

namespace App;

use App\Traits\HasRole;
use Facades\App\Helpers\Gravatar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'dob', 'occupation', 'organization', 'github_username', 'linkedin_username', 'website', 'newsletter', 'activated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be appended to arrays.
     *
     * @var array
     */
    protected $appends = [
        'gravatar'
    ];

    /**
     * Find the user by its username.
     *
     * @param Builder $query
     * @param         $username
     * @param array   $columns
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function scopeFindByUsername(Builder $query, $username, array $columns = ['*'])
    {
        return $query->whereUsername($username)->first($columns);
    }

    /**
     * Get the gravatar url for the user.
     *
     * @return string
     */
    public function getGravatarAttribute()
    {
        return Gravatar::src($this->email);
    }

    /**
     * A User may have multiple activation tokens.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activations()
    {
        return $this->hasMany(Activation::class);
    }

    /**
     * A User may have multiple datasets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function datasets()
    {
        return $this->hasMany(Dataset::class);
    }

    /**
     * A User may have multiple codes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codes()
    {
        return $this->hasMany(Code::class);
    }

    /**
     * A User may have multiple threads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * A User may have multiple replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * A User may have multiple votes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Get a string path for the user.
     *
     * @return string
     */
    public function path()
    {
        return "/u/{$this->username}";
    }

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }
}

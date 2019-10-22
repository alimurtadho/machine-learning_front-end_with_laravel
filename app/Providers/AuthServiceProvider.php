<?php

namespace App\Providers;

use App\Category;
use App\Code;
use App\Dataset;
use App\Policies\CategoryPolicy;
use App\Policies\CodePolicy;
use App\Policies\DatasetPolicy;
use App\Policies\ReplyPolicy;
use App\Policies\ThreadPolicy;
use App\Policies\TwitterFeedPolicy;
use App\Reply;
use App\Thread;
use App\TwitterFeed;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * @var array
     */
    protected $policies = [
        Category::class    => CategoryPolicy::class,
        Code::class        => CodePolicy::class,
        Dataset::class     => DatasetPolicy::class,
        Reply::class       => ReplyPolicy::class,
        Thread::class      => ThreadPolicy::class,
        TwitterFeed::class => TwitterFeedPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     * @return void
     */
    public function boot ()
    {
        $this->registerPolicies();
    }
}

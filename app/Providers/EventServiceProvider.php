<?php

namespace App\Providers;

use App\Events\TweetRetrieved;
use App\Events\UserRegistered;
use App\Events\UserUpdated;
use App\Listeners\SaveTweet;
use App\Listeners\UpdateNewsletterSubscription;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        TweetRetrieved::class => [
            SaveTweet::class,
        ],
        UserRegistered::class => [
            UpdateNewsletterSubscription::class,
        ],
        UserUpdated::class => [
            UpdateNewsletterSubscription::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

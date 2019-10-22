<?php

namespace App\Listeners;

use Newsletter;
use App\Events\UserUpdated;
use App\Events\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateNewsletterSubscription
{
    /**
     * Handle the event.
     *
     * @param UserRegistered|UserUpdated $event
     *
     * @return void
     */
    public function handle ($event)
    {
        if ($event->user->newsletter) {
            Newsletter::subscribeOrUpdate($event->user->email);
        } else {
            Newsletter::unsubscribe($event->user->email);
        }
    }
}

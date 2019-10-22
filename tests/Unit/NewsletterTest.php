<?php

namespace Tests\Unit;

use App\Mail\WeeklyNewsletter;
use Artisan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mail;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function newsletter_must_be_sent_to_each_subscribed_user_weekly ()
    {
        Mail::fake();

        create('App\TwitterFeed', [], 10);
        create('App\User', [], 5);

        Artisan::call('newsletter:weekly');

        Mail::assertSent(WeeklyNewsletter::class);
    }
}

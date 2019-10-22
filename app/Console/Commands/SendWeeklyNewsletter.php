<?php

namespace App\Console\Commands;

use Mail;
use App\Mail\WeeklyNewsletter;
use App\Policies\TwitterFeedPolicy;
use App\TwitterFeed;
use App\User;
use Illuminate\Console\Command;

class SendWeeklyNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly newsletter to all the users.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNewsletter(true)->take(1)->get();
        $twitterFeeds = TwitterFeed::trending()->take(5)->get();

        foreach($users as $user) {
            Mail::to($user)->send(new WeeklyNewsletter($twitterFeeds));
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Events\TweetRetrieved;
use TwitterStreamingApi;
use Illuminate\Console\Command;

class ListenForHashTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen for hash tags on twitter.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        TwitterStreamingApi::publicStream()
                           ->whenHears(['#ai'], function (array $tweet) {
                               event(new TweetRetrieved($tweet));
                           })
                           ->startListening();
    }
}

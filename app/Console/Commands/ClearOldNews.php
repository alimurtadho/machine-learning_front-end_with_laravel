<?php

namespace App\Console\Commands;

use App\TwitterFeed;
use Illuminate\Console\Command;

class ClearOldNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitter:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old news';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = TwitterFeed::count();
        $max = 10000;

        if($count <= $max) return;

        TwitterFeed::orderBy('id', 'desc')
            ->take($count - $max)
            ->skip($max)
            ->delete();
    }
}

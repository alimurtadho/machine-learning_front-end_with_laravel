<?php

namespace App\Listeners;

use App\Events\TweetRetrieved;
use App\TwitterFeed;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SaveTweet
{
    /**
     * Handle the event.
     *
     * @param  TweetRetrieved $event
     *
     * @return void
     */
    public function handle (TweetRetrieved $event)
    {
        $body = $event->tweet['text'];

        if(TwitterFeed::whereBody($body)->count()){
            return;
        }

        $media = $event->tweet['entities']['media'][0]['media_url'] ?? null;
        $tags = array_pluck($event->tweet['entities']['hashtags'] ?? [], 'text');
        if($event->tweet['truncated']) {
            $body = $event->tweet['extended_tweet']['full_text'];
            $media = $event->tweet['extended_tweet']['entities']['media'][0]['media_url'] ?? null;
            $tags = array_pluck($event->tweet['extended_tweet']['entities']['hashtags'] ?? [], 'text');
        }

        if($rt = $event->tweet['retweeted_status'] ?? false) {
            $media = $rt['truncated'] ? ($rt['extended_tweet']['entities']['media'][0]['media_url'] ?? null) : ($rt['entities']['media'][0]['media_url'] ?? null);
        }

        TwitterFeed::create([
            'twitter_id' => $event->tweet['id_str'],
            'body' => $body,
            'user_id' => $event->tweet['user']['id_str'],
            'author_name' => $event->tweet['user']['name'],
            'author_screen_name' => $event->tweet['user']['screen_name'],
            'author_verified' => $event->tweet['user']['verified'],
            'twitter_timestamp' => Carbon::createFromTimestamp($event->tweet['timestamp_ms']/1000),
            'media' => $media,
            'tags' => $tags,
        ]);
    }
}

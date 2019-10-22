<?php

namespace App\Observers;

use App\TwitterFeed;

class TwitterFeedObserver
{
    protected $keywords = [
        'medicine',
        'cancer',
        'disease',
        'diagnosis',
        'medical',
        'doctor',
        'hospital',
        'treatment',
        'diabetes',
        'breast',
        'lung',
        'brain',
        'tumor',
        'health',
        'health care',
        'clinic',
        'prescription',
        'drugs',
        'pacemaker',
        'digitalhealth',
        'cognitive',
    ];

    /**
     * Listen to the TwitterFeed created event.
     *
     * @param  TwitterFeed $feed
     *
     * @return void
     */
    public function created (TwitterFeed $feed)
    {
        if(env('APP_ENV') == 'testing'){
            return;
        }

        if (TwitterFeed::search(implode(' ', $this->keywords))->where('id', $feed->id)->first()) {
            $feed->update(['medicine_related' => true]);
        }
    }

    /**
     * Listen to the TwitterFeed saving event.
     *
     * @param TwitterFeed $feed
     *
     * @return void
     */
    public function saving(TwitterFeed $feed)
    {
        if(env('APP_ENV') == 'testing'){
            return;
        }

        if (TwitterFeed::search(implode(' ', $this->keywords))->where('id', $feed->id)->first()) {
            $feed->medicine_related = true;
        }
    }
}
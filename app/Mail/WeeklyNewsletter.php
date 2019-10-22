<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

class WeeklyNewsletter extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Collection
     */
    public $twitterFeeds;

    /**
     * @var string
     */
    public $subject = "Popular This Week";

    /**
     * Create a new message instance.
     *
     * @param Collection $twitterFeeds
     */
    public function __construct(Collection $twitterFeeds)
    {
        $this->twitterFeeds = $twitterFeeds;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newsletter.weekly');
    }
}

<?php

namespace App\Observers;

use App\Thread;

class ThreadObserver
{
    /**
     * Listen to the Thread creating event.
     *
     * @param  Thread  $thread
     * @return void
     */
    public function creating(Thread $thread)
    {
        $thread->body_html = markdownToDemotedHtml($thread->body);
    }

    /**
     * Listen to the Thread saving event.
     *
     * @param  Thread  $thread
     * @return void
     */
    public function saving(Thread $thread)
    {
        $thread->body_html = markdownToDemotedHtml($thread->body);
    }
}
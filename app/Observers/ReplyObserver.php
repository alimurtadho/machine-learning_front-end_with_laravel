<?php

namespace App\Observers;

use App\Reply;

class ReplyObserver
{
    /**
     * Listen to the Reply creating event.
     *
     * @param  Reply  $reply
     * @return void
     */
    public function creating(Reply $reply)
    {
        $reply->body_html = markdownToDemotedHtml($reply->body);
    }

    /**
     * Listen to the Reply saving event.
     *
     * @param  Reply  $reply
     * @return void
     */
    public function saving(Reply $reply)
    {
        $reply->body_html = markdownToDemotedHtml($reply->body);
    }
}
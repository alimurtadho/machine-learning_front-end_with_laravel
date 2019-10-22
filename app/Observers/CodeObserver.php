<?php

namespace App\Observers;

use App\Code;

class CodeObserver
{
    /**
     * Listen to the Code creating event.
     *
     * @param  Code  $code
     * @return void
     */
    public function creating(Code $code)
    {
        $code->description_html = markdownToDemotedHtml($code->description);
    }

    /**
     * Listen to the Code saving event.
     *
     * @param  Code  $code
     * @return void
     */
    public function saving(Code $code)
    {
        $code->description_html = markdownToDemotedHtml($code->description);
    }
}
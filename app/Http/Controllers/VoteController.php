<?php

namespace App\Http\Controllers;

use App\Code;
use App\Dataset;
use App\TwitterFeed;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:vote,dataset')->only('dataset');
        $this->middleware('can:vote,code')->only('code');
        $this->middleware('can:vote,twitter_feed')->only('news');
    }

    public function dataset(Dataset $dataset)
    {
        $dataset->isVoted() ? $dataset->abstain() : $dataset->vote();

        if(request()->ajax()){
            return $dataset->votes()->count();
        }

        return back();
    }

    public function code(Code $code)
    {
        $code->isVoted() ? $code->abstain() : $code->vote();

        if(request()->ajax()){
            return $code->votes()->count();
        }

        return back();
    }

    public function news(TwitterFeed $twitterFeed)
    {
        $twitterFeed->isVoted() ? $twitterFeed->abstain() : $twitterFeed->vote();

        if(request()->ajax()){
            return $twitterFeed->votes()->count();
        }

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Filters\TwitterFeedFilters;
use App\TwitterFeed;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param TwitterFeedFilters $filters
     *
     * @return \Illuminate\Http\Response
     */
    public function index (TwitterFeedFilters $filters)
    {
        $twitterFeeds = TwitterFeed::filter($filters)
                                   ->orderBy('created_at', 'desc')
                                   ->paginate(20)
                                   ->appends(request()->all());

        return view('news.index', compact('twitterFeeds'));
    }
}

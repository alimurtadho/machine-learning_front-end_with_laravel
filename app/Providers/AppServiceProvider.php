<?php

namespace App\Providers;

use Cache;
use View;
use App\Code;
use App\Observers\TwitterFeedObserver;
use App\Reply;
use App\Thread;
use App\Dataset;
use App\Category;
use App\Observers\CodeObserver;
use App\Observers\ReplyObserver;
use App\Observers\ThreadObserver;
use App\Observers\DatasetObserver;
use App\TwitterFeed;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['threads.create', 'threads.edit'], function ($view) {
            $categoryList = Cache::rememberForever('categoryList', function(){
                return Category::orderBy('name')->pluck('id', 'name');
            });

            $view->with('categoryList', $categoryList);
        });

        View::composer(['threads._sidebar'], function ($view) {
            $categories = Cache::rememberForever('categories', function(){
                return Category::orderBy('name')->get();
            });

            $view->with('categories', $categories);
        });

        Dataset::observe(DatasetObserver::class);
        Code::observe(CodeObserver::class);
        Thread::observe(ThreadObserver::class);
        Reply::observe(ReplyObserver::class);
        TwitterFeed::observe(TwitterFeedObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! class_exists('Aimed')) {
            class_alias('App\Aimed', 'Aimed');
        }

        if($this->app->isLocal()){
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}

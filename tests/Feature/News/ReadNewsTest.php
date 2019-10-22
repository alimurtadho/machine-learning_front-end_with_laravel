<?php

namespace Tests\Feature\News;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReadNewsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function anyone_can_view_news ()
    {
        $allNews = create('App\TwitterFeed', [], 5);

        $response = $this->get('/news');

        foreach ($allNews as $news) {
            $response->assertSee($news->body);
        }
    }

    /** @test */
    public function anyone_can_view_medical_news ()
    {
        $news         = create('App\TwitterFeed');
        $medicineNews = create('App\TwitterFeed', ['medicine_related' => true]);

        $response = $this->get('/news?medicine=1');

        $response->assertDontSee($news->body);
        $response->assertSee($medicineNews->body);
    }

    /** @test */
    public function anyone_can_view_trending_news ()
    {
        $this->signIn();

        $news = create('App\TwitterFeed', ['created_at' => Carbon::now()->subDays(10)]);
        $news->vote();

        $this->get('/news?trending=1')
             ->assertDontSee($news->body);

        $news = create('App\TwitterFeed');
        $news->vote();

        $this->get('/news?trending=1')
             ->assertSee($news->body);
    }

    /** @test */
    public function anyone_can_view_popular_news ()
    {
        $this->signIn();

        $allNews = create('App\TwitterFeed', [], 30)->random(3);
        foreach ($allNews as $news) {
            $news->vote();
        }

        foreach ($allNews as $news) {
            $this->get('/news?popular=1')
                 ->assertSee($news->body);
        }
    }
}

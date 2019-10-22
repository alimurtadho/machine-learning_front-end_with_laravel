<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $news;

    public function setUp ()
    {
        parent::setUp();
        $this->news = create('App\TwitterFeed');
        $this->fakeVotes();
    }

    protected function fakeVotes ($times = 10)
    {
        for ($i = 1; $i <= $times; $i++) {
            $this->news->votes()->create(['user_id' => create('App\User')->id]);
        }
    }

    /** @test */
    public function a_news_has_many_votes ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->news->votes
        );

        foreach ($this->news->votes as $vote) {
            $this->assertInstanceOf('App\Vote', $vote);
        }
    }
}

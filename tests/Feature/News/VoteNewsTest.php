<?php

namespace Tests\Feature\News;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VoteNewsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $news;

    public function setUp ()
    {
        parent::setUp();
        $this->news = create('App\TwitterFeed');
    }

    /** @test */
    public function unauthenticated_users_may_not_vote_for_news ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->post($this->news->path() . '/vote');
    }

    /** @test */
    public function authenticated_users_may_vote_for_a_news_but_only_once ()
    {
        $this->signIn();

        $this->post($this->news->path() . '/vote');

        $this->assertEquals(1, $this->news->votes()->count());

        $this->post($this->news->path() . '/vote');

        $this->assertEquals(0, $this->news->votes()->count());
    }
}

<?php

namespace Tests\Feature\Discussion;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReadDiscussionsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $discussion;

    public function setUp ()
    {
        parent::setUp();
        $this->discussion = create('App\Thread');
    }

    /** @test */
    public function anyone_can_view_discussions ()
    {
        $this->get('/discuss')
             ->assertSee($this->discussion->name);
    }

    /** @test */
    public function anyone_can_view_trending_discussions ()
    {
        $discussion = create('App\Thread', ['created_at' => Carbon::now()->subDays(10)]);
        create('App\Reply', ['thread_id' => $discussion->id], 5);

        $this->get('/discuss?trending=1')
             ->assertDontSee($discussion->name);

        $discussion = create('App\Thread');
        create('App\Reply', ['thread_id' => $discussion->id], 5);

        $this->get('/discuss?trending=1')
             ->assertSee($discussion->name);
    }

    /** @test */
    public function anyone_can_view_popular_discussions ()
    {
        $discussions = create('App\Thread', [], 30)->random(3);
        foreach ($discussions as $discussion) {
            create('App\Reply', ['thread_id' => $discussion->id], rand(1, 10));
        }

        $response = $this->get('/discuss?popular=1');
        foreach ($discussions as $discussion) {
            $response->assertSee($discussion->name);
        }
    }

    /** @test */
    public function anyone_can_view_answered_discussions ()
    {
        $discussion = create('App\Thread', ['answered' => true]);

        $this->get('/discuss?answered=true')
             ->assertSee($discussion->name);
    }

    /** @test */
    public function anyone_can_view_unanswered_discussions ()
    {
        $discussion = create('App\Thread', ['answered' => false]);

        $this->get('/discuss?answered=false')
             ->assertSee($discussion->name);
    }

    /** @test */
    public function authenticated_user_may_view_their_discussions ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $discussion = create('App\Thread');
        $this->get('/discuss?author=' . $user->username)
             ->assertDontSee($discussion->name);

        $discussion = create('App\Thread', ['user_id' => $user->id]);
        $this->get('/discuss?author=' . $user->username)
             ->assertSee($discussion->name);
    }

    /** @test */
    public function authenticated_user_may_view_participated_discussions ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $discussion = create('App\Thread');
        $this->get('/discuss?contributor=' . $user->username)
             ->assertDontSee($discussion->name);

        $discussion = create('App\Thread', ['user_id' => $user->id]);
        $this->get('/discuss?contributor=' . $user->username)
             ->assertSee($discussion->name);

        $replies = create('App\Reply', ['user_id' => $user->id], 5);

        $response = $this->get('/discuss?contributor=' . $user->username);
        foreach ($replies as $reply) {
            $response->assertSee($reply->thread->name);
        }
    }

    /** @test */
    public function a_discussion_must_be_viewable ()
    {
        $this->get($this->discussion->path())
             ->assertSee($this->discussion->name);
    }

    /** @test */
    public function a_discussion_must_show_its_replies ()
    {
        $replies  = create('App\Reply', ['thread_id' => $this->discussion->id], 5);
        $response = $this->get($this->discussion->path());
        foreach ($replies as $reply) {
            $response->assertSee($reply->body_html);
        }
    }

    /** @test */
    public function anyone_can_search_for_discussions ()
    {
        $discussion = create('App\Thread');
        create('App\Thread', [], 30);

        $this->get('/discuss?search=' . $discussion->name)
             ->assertSee($discussion->name);
    }

    /** @test */
    function anyone_can_filter_threads_according_to_a_category ()
    {
        $category            = create('App\Category');
        $threadInCategory    = create('App\Thread', ['category_id' => $category->id]);
        $threadNotInCategory = create('App\Thread');
        $this->get($category->path())
             ->assertSee($threadInCategory->name)
             ->assertDontSee($threadNotInCategory->name);
    }
}

<?php

namespace Tests\Feature\Discussion;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ParticipateInDiscussionsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $user;
    protected $discussion;

    public function setUp ()
    {
        parent::setUp();
        $this->user       = create('App\User');
        $this->discussion = create('App\Thread', ['user_id' => $this->user->id]);
    }

    /** @test */
    public function unauthenticated_users_may_not_participate_in_discussions ()
    {
        $this->get($this->discussion->path())
             ->assertDontSee('Leave a Reply');

        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->disableExceptionHandling()
             ->post($this->discussion->path() . '/replies');
    }

    /** @test */
    public function authenticated_user_may_participate_in_discussions ()
    {
        $this->signIn();
        $this->get($this->discussion->path())
             ->assertSee('Leave a Reply');

        $this->disableExceptionHandling()
             ->leaveReply();
    }

    /** @test */
    public function a_reply_requires_a_valid_body_for_creation ()
    {
        $this->leaveReply(['body' => null])
             ->assertSessionHasErrors('body');

        $this->leaveReply(['body' => str_random(5001)])
             ->assertSessionHasErrors('body');

        $this->leaveReply(['body' => str_random(1000)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function unauthenticated_users_may_not_select_best_reply ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->selectBestReply();
    }

    /** @test */
    public function users_other_than_creator_may_not_select_best_reply ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->signIn()
             ->selectBestReply();
    }

    /** @test */
    public function owner_may_select_best_reply ()
    {
        $this->disableExceptionHandling()
             ->signIn($this->user)
             ->selectBestReply(['thread_id' => $this->discussion->id]);

        $this->assertDatabaseHas('threads', ['id' => $this->discussion->id, 'answered' => true]);
    }

    /** @test */
    public function admin_may_not_select_best_reply ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->signIn($this->createAdmin())
             ->selectBestReply();
    }

    protected function selectBestReply ($overrides = [])
    {
        $reply = create('App\Reply', $overrides);

        return $this->post($reply->path());
    }

    protected function leaveReply ($overrides = [])
    {
        $this->signIn();
        $reply = make('App\Reply', $overrides);

        return $this->post($this->discussion->path() . '/replies', $reply->toArray());
    }
}

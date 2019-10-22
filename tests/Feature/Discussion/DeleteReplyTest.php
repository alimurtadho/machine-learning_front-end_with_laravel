<?php

namespace Tests\Feature\Discussion;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteReplyTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $user;
    protected $reply;

    public function setUp ()
    {
        parent::setUp();
        $this->user  = create('App\User');
        $this->reply = create('App\Reply', ['user_id' => $this->user->id]);
    }

    /** @test */
    public function unauthenticated_users_may_not_delete_any_reply ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->delete($this->reply->path());
    }

    /** @test */
    public function users_other_than_creator_or_admin_may_not_delete_any_reply ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->signIn()
             ->delete($this->reply->path());
    }

    /** @test */
    public function creator_may_delete_reply ()
    {
        $this->signIn($this->user);
        $this->delete($this->reply->path());
        $this->assertDatabaseMissing('replies', ['id' => $this->reply->id]);
    }

    /** @test */
    public function admin_may_delete_any_reply ()
    {
        $this->signIn($this->createAdmin());

        $this->delete($this->reply->path());
        $this->assertDatabaseMissing('replies', ['id' => $this->reply->id]);
    }
}

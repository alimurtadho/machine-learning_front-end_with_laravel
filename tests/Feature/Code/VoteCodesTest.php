<?php

namespace Tests\Feature\Code;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VoteCodesTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $user;
    protected $code;

    public function setUp ()
    {
        parent::setUp();
        $this->user = create('App\User');
        $this->code = create('App\Code', ['user_id' => $this->user->id, 'published' => false]);
    }

    /** @test */
    public function unauthenticated_users_may_not_vote_for_a_code ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->post($this->code->path() . '/vote');
    }

    /** @test */
    public function authenticated_users_may_vote_for_a_code_but_only_once ()
    {
        $this->signIn($this->user);

        $this->post($this->code->path() . '/vote');

        $this->assertEquals(1, $this->code->votes()->count());

        $this->post($this->code->path() . '/vote');

        $this->assertEquals(0, $this->code->votes()->count());
    }
}

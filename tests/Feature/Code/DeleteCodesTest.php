<?php

namespace Tests\Feature\Code;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteCodesTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $user;
    protected $code;

    public function setUp ()
    {
        parent::setUp();
        $this->user = create('App\User');
        $this->code = create('App\Code', ['user_id' => $this->user->id]);
    }

    /** @test */
    public function unauthenticated_users_may_not_delete_any_code ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->delete($this->code->path());
    }

    /** @test */
    public function users_other_than_admin_may_not_delete_code ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->signIn($this->user)
             ->delete($this->code->path());
    }

    /** @test */
    public function admin_may_delete_any_code ()
    {
        $this->signIn($this->createAdmin());

        $this->delete($this->code->path());
        $this->assertDatabaseMissing('codes', ['id' => $this->code->id]);
    }
}

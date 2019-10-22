<?php

namespace Tests\Feature\Dataset;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DeleteDatasetsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $user;
    protected $dataset;

    public function setUp ()
    {
        parent::setUp();
        $this->user    = create('App\User');
        $this->dataset = create('App\Dataset', ['user_id' => $this->user->id, 'published' => false]);
    }

    /** @test */
    public function unauthenticated_users_may_not_delete_any_dataset ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->delete($this->dataset->path());
    }

    /** @test */
    public function users_other_than_admin_may_not_delete_any_dataset ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->disableExceptionHandling()
             ->signIn($this->user)
             ->delete($this->dataset->path());
    }

    /** @test */
    public function admin_may_delete_any_dataset ()
    {
        $this->signIn($this->createAdmin());

        $this->delete($this->dataset->path());
        $this->assertDatabaseMissing('datasets', ['id' => $this->dataset->id]);
    }
}

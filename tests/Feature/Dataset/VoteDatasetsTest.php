<?php

namespace Tests\Feature\Dataset;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class VoteDatasetsTest extends TestCase
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
    public function unauthenticated_users_may_not_vote_for_dataset ()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->disableExceptionHandling()
             ->post($this->dataset->path() . '/vote');
    }

    /** @test */
    public function authenticated_users_may_vote_for_a_dataset_but_only_once ()
    {
        $this->signIn($this->user);

        $this->post($this->dataset->path() . '/vote');

        $this->assertEquals(1, $this->dataset->votes()->count());

        $this->post($this->dataset->path() . '/vote');

        $this->assertEquals(0, $this->dataset->votes()->count());
    }
}

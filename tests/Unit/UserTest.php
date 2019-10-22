<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $user;

    public function setUp ()
    {
        parent::setUp();
        $this->user = create('App\User');
        create('App\Activation', ['user_id' => $this->user->id]);
        $dataset = create('App\Dataset', ['user_id' => $this->user->id]);
        $dataset->votes()->create(['user_id' => $this->user->id]);
        create('App\Code', ['user_id' => $this->user->id]);
        create('App\Thread', ['user_id' => $this->user->id]);
        create('App\Reply', ['user_id' => $this->user->id]);
        $role = create('App\Role');
        $this->user->attachRole($role);
    }

    /** @test */
    public function a_user_has_many_activations ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->activations
        );

        foreach ($this->user->activations as $activation) {
            $this->assertInstanceOf('App\Activation', $activation);
        }
    }

    /** @test */
    public function a_user_has_many_datasets ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->datasets
        );

        foreach ($this->user->datasets as $dataset) {
            $this->assertInstanceOf('App\Dataset', $dataset);
        }
    }

    /** @test */
    public function a_user_has_many_codes ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->codes
        );

        foreach ($this->user->codes as $code) {
            $this->assertInstanceOf('App\Code', $code);
        }
    }

    /** @test */
    public function a_user_has_many_threads ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->threads
        );

        foreach ($this->user->threads as $thread) {
            $this->assertInstanceOf('App\Thread', $thread);
        }
    }

    /** @test */
    public function a_user_has_many_replies ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->replies
        );

        foreach ($this->user->replies as $reply) {
            $this->assertInstanceOf('App\Reply', $reply);
        }
    }

    /** @test */
    public function a_user_has_many_votes ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->votes
        );

        foreach ($this->user->votes as $vote) {
            $this->assertInstanceOf('App\Vote', $vote);
        }
    }

    /** @test */
    public function a_user_has_many_roles ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->user->roles
        );

        foreach ($this->user->roles as $role) {
            $this->assertInstanceOf('App\Role', $role);
        }
    }
}

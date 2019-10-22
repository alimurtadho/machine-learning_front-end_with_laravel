<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $thread;

    public function setUp ()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $this->thread->id]);
    }

    /** @test */
    public function a_thread_belongs_to_a_user ()
    {
        $this->assertInstanceOf(
            'App\User', $this->thread->creator
        );
    }

    /** @test */
    public function a_thread_belongs_to_a_category ()
    {
        $this->assertInstanceOf(
            'App\Category', $this->thread->category
        );
    }

    /** @test */
    public function a_thread_has_many_replies ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->thread->replies
        );

        foreach ($this->thread->replies as $reply) {
            $this->assertInstanceOf('App\Reply', $reply);
        }
    }
}

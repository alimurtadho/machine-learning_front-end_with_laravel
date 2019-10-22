<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $reply;

    public function setUp ()
    {
        parent::setUp();
        $this->reply = create('App\Reply');
    }

    /** @test */
    public function a_reply_belongs_to_a_user ()
    {
        $this->assertInstanceOf(
            'App\User', $this->reply->creator
        );
    }

    /** @test */
    public function a_reply_belongs_belongs_to_a_thread ()
    {
        $this->assertInstanceOf(
            'App\Thread', $this->reply->thread
        );
    }
}

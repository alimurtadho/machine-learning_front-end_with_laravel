<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CodeTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $code;

    public function setUp ()
    {
        parent::setUp();
        $this->code = create('App\Code');
        $this->fakeVotes();
    }

    protected function fakeVotes ($times = 10)
    {
        for ($i = 1; $i <= $times; $i++) {
            $this->code->votes()->create(['user_id' => create('App\User')->id]);
        }
    }

    /** @test */
    public function a_code_has_a_creator ()
    {
        $this->assertInstanceOf(
            'App\User', $this->code->creator
        );
    }

    /** @test */
    public function a_code_belongs_to_a_dataset ()
    {
        $this->assertInstanceOf(
            'App\Dataset', $this->code->dataset
        );
    }

    /** @test */
    public function a_code_has_many_votes ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->code->votes
        );

        foreach ($this->code->votes as $vote) {
            $this->assertInstanceOf('App\Vote', $vote);
        }
    }
}

<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DatasetTest extends TestCase
{
    use DatabaseMigrations;
    protected $dataset;

    public function setUp ()
    {
        parent::setUp();
        $this->dataset = create('App\Dataset');
        create('App\Code', ['dataset_id' => $this->dataset]);
        $this->fakeVotes();
    }

    protected function fakeVotes ($times = 10)
    {
        for ($i = 1; $i <= $times; $i++) {
            $this->dataset->votes()->create(['user_id' => create('App\User')->id]);
        }
    }

    /** @test */
    public function a_dataset_has_a_creator ()
    {
        $this->assertInstanceOf(
            'App\User', $this->dataset->creator
        );
    }

    /** @test */
    public function a_dataset_has_many_codes ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->dataset->codes
        );

        foreach ($this->dataset->codes as $code) {
            $this->assertInstanceOf('App\Code', $code);
        }
    }

    /** @test */
    public function a_dataset_has_many_votes ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->dataset->votes
        );

        foreach ($this->dataset->votes as $vote) {
            $this->assertInstanceOf('App\Vote', $vote);
        }
    }
}

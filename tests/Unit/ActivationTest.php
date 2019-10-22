<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ActivationTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $activation;

    public function setUp ()
    {
        parent::setUp();
        $this->activation = create('App\Activation');
    }

    /** @test */
    public function an_activation_belongs_to_a_user ()
    {
        $this->assertInstanceOf(
            'App\User', $this->activation->user
        );
    }
}

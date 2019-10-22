<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $category;

    public function setUp ()
    {
        parent::setUp();
        $this->category = create('App\Category');
        create('App\Thread', ['category_id' => $this->category->id]);
    }

    /** @test */
    public function a_category_has_many_threads ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection',
            $this->category->threads
        );

        foreach ($this->category->threads as $thread) {
            $this->assertInstanceOf('App\Thread', $thread);
        }
    }
}

<?php

namespace Tests\Feature\Discussion;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateDiscussionsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function unauthenticated_users_may_not_create_discussions ()
    {
        $this->get('/discuss/create')
             ->assertRedirect('/login');

        $this->post('/discuss')
             ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_may_create_discussions ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $discussion = make('App\Thread');
        $this->post('/discuss', $discussion->toArray());

        $this->assertDatabaseHas('threads', [
            'name'        => $discussion->name,
            'body'        => $discussion->body,
            'user_id'     => $user->id,
            'category_id' => $discussion->category_id,
        ]);
    }

    /** @test */
    public function a_discussion_requires_a_valid_name_for_creation ()
    {
        $this->startDiscussion(['name' => null])
             ->assertSessionHasErrors('name');

        $this->startDiscussion(['name' => str_random(300)])
             ->assertSessionHasErrors('name');

        $this->startDiscussion(['name' => str_random(51)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_discussion_requires_a_valid_body_for_creation ()
    {
        $this->startDiscussion(['body' => null])
             ->assertSessionHasErrors('body');

        $this->startDiscussion(['body' => str_random(10001)])
             ->assertSessionHasErrors('body');

        $this->startDiscussion(['body' => str_random(1000)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_discussion_requires_valid_category_for_creation ()
    {
        $this->startDiscussion(['category_id' => 0])
             ->assertSessionHasErrors('category_id');

        $category = create('App\Category');
        $this->startDiscussion(['category_id' => $category->id])
             ->assertSessionMissing('errors');
    }

    protected function startDiscussion ($overrides = [])
    {
        $this->signIn();
        $discussion = make('App\Thread', $overrides);

        return $this->post('/discuss', $discussion->toArray());
    }
}

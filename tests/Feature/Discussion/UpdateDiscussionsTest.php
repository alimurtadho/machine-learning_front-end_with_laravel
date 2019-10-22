<?php

namespace Tests\Feature\Discussion;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateDiscussionsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $user;
    protected $discussion;

    public function setUp ()
    {
        parent::setUp();
        $this->user       = create('App\User');
        $this->discussion = create('App\Thread', ['user_id' => $this->user->id]);
    }

    /** @test */
    public function unauthenticated_users_may_not_edit_discussions ()
    {
        $this->get($this->discussion->path() . '/edit')
             ->assertRedirect('/login');

        $this->put($this->discussion->path())
             ->assertRedirect('/login');
    }

    /** @test */
    public function users_other_than_admin_and_creator_may_not_view_edit_discussion_page ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->get($this->discussion->path() . '/edit');
    }

    /** @test */
    public function users_other_than_admin_and_creator_may_not_edit_discussion ()
    {
        $this->disableExceptionHandling()->signIn();

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->put($this->discussion->path());
    }

    /** @test */
    public function creator_may_edit_discussion ()
    {
        $this->disableExceptionHandling()->signIn($this->user);

        $this->get($this->discussion->path() . '/edit')
             ->assertStatus(200);

        $this->expectException('Illuminate\Validation\ValidationException');
        $this->put($this->discussion->path());
    }

    /** @test */
    public function admin_may_edit_discussion ()
    {
        $this->disableExceptionHandling()->signIn($this->createAdmin());

        $this->get($this->discussion->path() . '/edit')
             ->assertStatus(200);

        $this->expectException('Illuminate\Validation\ValidationException');
        $this->put($this->discussion->path());
    }

    /** @test */
    public function a_discussion_requires_a_valid_name_on_update ()
    {
        $this->updateDiscussion(['name' => null])
             ->assertSessionHasErrors('name');

        $this->updateDiscussion(['name' => str_random(300)])
             ->assertSessionHasErrors('name');

        $this->updateDiscussion(['name' => str_random(51)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_discussion_requires_a_valid_body_on_update ()
    {
        $this->updateDiscussion(['body' => null])
             ->assertSessionHasErrors('body');

        $this->updateDiscussion(['body' => str_random(10001)])
             ->assertSessionHasErrors('body');

        $this->updateDiscussion(['body' => str_random(1000)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_discussion_requires_valid_category_on_update ()
    {
        $this->signIn($this->user)
             ->put($this->discussion->path(), ['category_id' => 0] + $this->discussion->toArray())
             ->assertSessionHasErrors('category_id');

        $category = create('App\Category');
        $this->updateDiscussion(['category_id' => $category->id])
             ->assertSessionMissing('errors');
    }

    protected function updateDiscussion ($overrides = [])
    {
        $this->signIn($this->user);
        $this->discussion->fill(raw('App\Thread', $overrides));

        return $this->put($this->discussion->path(), $this->discussion->toArray());
    }
}

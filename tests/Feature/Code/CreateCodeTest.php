<?php

namespace Tests\Feature\Dataset;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateCodeTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function unauthenticated_users_may_not_create_codes ()
    {
        $dataset = create('App\Dataset');
        $this->get("/c/{$dataset->slug}/publish")
             ->assertRedirect('/login');

        $this->post('/codes')
             ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_may_not_create_code_for_unpublished_datasets ()
    {
        $dataset = create('App\Dataset', ['published' => false]);

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');
        $this->disableExceptionHandling()
             ->signIn()
             ->get("/c/{$dataset->slug}/publish");
    }

    /** @test */
    public function authenticated_user_may_create_codes ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $dataset = create('App\Dataset');
        $code    = make('App\Code', ['dataset_id' => $dataset->id]);

        $this->post('/codes', $code->toArray());

        $this->assertDatabaseHas('codes', [
            'name'        => $code->name,
            'description' => $code->description,
            'code'        => $code->code,
            'user_id'     => $user->id,
            'dataset_id'  => $dataset->id,
            'published'   => false,
        ]);
    }

    /** @test */
    public function a_code_requires_a_valid_name_for_creation ()
    {
        $this->publishCode(['name' => null])
             ->assertSessionHasErrors('name');

        $this->publishCode(['name' => str_random(5)])
             ->assertSessionHasErrors('name');

        $this->publishCode(['name' => str_random(51)])
             ->assertSessionHasErrors('name');

        $this->publishCode(['name' => str_random(20)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_code_requires_a_valid_description_for_creation ()
    {
        $this->publishCode(['description' => null])
             ->assertSessionHasErrors('description');

        $this->publishCode(['description' => str_random(20001)])
             ->assertSessionHasErrors('description');

        $this->publishCode(['description' => str_random(1000)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_code_requires_valid_code_for_creation ()
    {
        $this->publishCode(['code' => null])
             ->assertSessionHasErrors('code');

        $this->publishCode(['code' => str_random(50001)])
             ->assertSessionHasErrors('code');

        $this->publishCode(['code' => str_random(1000)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_code_requires_valid_dataset_for_creation ()
    {
        $this->publishCode(['dataset_id' => 0])
             ->assertSessionHasErrors('dataset_id');

        $dataset = create('App\Dataset', ['published' => false]);
        $this->publishCode(['dataset_id' => $dataset->id])
             ->assertSessionHasErrors('dataset_id');

        $dataset = create('App\Dataset');
        $this->publishCode(['dataset_id' => $dataset->id])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_code_requires_valid_publish_value_for_creation ()
    {
        $this->publishCode(['publish' => 'string'])
             ->assertSessionHasErrors('publish');

        $this->publishCode(['publish' => true])
             ->assertSessionMissing('errors');
    }

    protected function publishCode ($overrides = [])
    {
        $this->signIn();
        $code = make('App\Code', $overrides);

        return $this->post('/codes', $code->toArray());
    }
}

<?php

namespace Tests\Feature\Dataset;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateDatasetsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function unauthenticated_users_may_not_create_datasets ()
    {
        $this->get('/datasets/publish')
             ->assertRedirect('/login');

        $this->post('/datasets')
             ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_may_create_datasets ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $dataset = make('App\Dataset');
        $this->post('/datasets', $dataset->toArray());

        $this->assertDatabaseHas('datasets', [
            'name'      => $dataset->name,
            'overview'  => $dataset->overview,
            'user_id'   => $user->id,
            'published' => false,
        ]);
    }

    /** @test */
    public function a_dataset_requires_a_valid_name_for_creation ()
    {
        $this->publishDataset(['name' => null])
             ->assertSessionHasErrors('name');

        $this->publishDataset(['name' => str_random(5)])
             ->assertSessionHasErrors('name');

        $this->publishDataset(['name' => str_random(51)])
             ->assertSessionHasErrors('name');

        $this->publishDataset(['name' => str_random(20)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_dataset_requires_a_valid_overview_for_creation ()
    {
        $this->publishDataset(['overview' => null])
             ->assertSessionHasErrors('overview');

        $this->publishDataset(['overview' => str_random(19)])
             ->assertSessionHasErrors('overview');

        $this->publishDataset(['overview' => str_random(81)])
             ->assertSessionHasErrors('overview');

        $this->publishDataset(['overview' => str_random(30)])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_dataset_requires_a_valid_description_for_creation ()
    {
        $this->publishDataset(['description' => null])
             ->assertSessionHasErrors('description');

        $this->publishDataset(['description' => str_random(20001)])
             ->assertSessionHasErrors('description');

        $this->publishDataset(['description' => str_random(1000)])
             ->assertSessionMissing('errors');
    }

    protected function publishDataset ($overrides = [])
    {
        $this->signIn();
        $dataset = make('App\Dataset', $overrides);

        return $this->post('/datasets', $dataset->toArray());
    }
}

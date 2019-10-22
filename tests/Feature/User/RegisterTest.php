<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function authenticated_users_may_not_create_account ()
    {
        $this->get('/register')
             ->assertStatus(200);

        $this->signIn()
             ->get('/register')
             ->assertStatus(302);
    }

    /** @test */
    public function confirmation_message_should_be_displayed_on_registration ()
    {
        $this->register()
             ->assertSessionHas('info');
    }

    /** @test */
    public function registration_requires_valid_name ()
    {
        $this->register(['name' => null])
             ->assertSessionHasErrors('name');

        $this->register(['name' => str_random(300)])
             ->assertSessionHasErrors('name');
    }

    /** @test */
    public function registration_requires_valid_unique_username ()
    {
        $this->register(['username' => null])
             ->assertSessionHasErrors('username');

        $this->register(['username' => str_random(3)])
             ->assertSessionHasErrors('username');

        $this->register(['username' => str_random(300)])
             ->assertSessionHasErrors('username');

        $user = create('App\User');
        $this->register(['username' => $user->username])
             ->assertSessionHasErrors('username');
    }

    /** @test */
    public function registration_requires_valid_unique_email ()
    {
        $this->register(['email' => null])
             ->assertSessionHasErrors('email');

        $this->register(['email' => str_random(10)])
             ->assertSessionHasErrors('email');

        $user = create('App\User');
        $this->register(['email' => $user->email])
             ->assertSessionHasErrors('email');
    }

    /** @test */
    public function registration_requires_valid_password ()
    {
        $this->register([], '')
             ->assertSessionHasErrors('password');

        $this->register([], str_random(5))
             ->assertSessionHasErrors('password');
    }

    /** @test */
    public function registration_requires_a_password_confirmation ()
    {
        $this->register([], 'anotherPassword')
             ->assertSessionHasErrors('password');

        $this->register([], str_random(5))
             ->assertSessionHasErrors('password');
    }

    protected function register ($overrides = [], $password = 'secret')
    {
        $user = make('App\User', $overrides);

        return $this->post('/register',
            ['password' => $password, 'password_confirmation' => 'secret'] + $user->toArray());
    }
}

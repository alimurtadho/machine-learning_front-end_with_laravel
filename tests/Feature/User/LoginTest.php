<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function authenticated_users_may_not_login ()
    {
        $this->get('/login')
             ->assertStatus(200);

        $this->signIn()
             ->get('/login')
             ->assertStatus(302);
    }

    /** @test */
    public function invalid_credentials_should_not_work_for_login ()
    {
        $user = create('App\User');

        $response = $this->post('/login',
            [
                'username' => $user->username,
                'password' => 'wrongPassword'
            ]
        );

        while ($response->isRedirect()) {
            $response = $this->get($response->headers->get('Location'));
        }

        $response->assertSee('Login');
    }

    /** @test */
    public function email_activation_pending_users_may_not_login ()
    {
        $user = create('App\User', ['activated' => false]);

        $response = $this->post('/login',
            [
                'username' => $user->username,
                'password' => 'secret'
            ]
        );

        $response->assertSessionHas('info',
            'You need to confirm your email address before logging in. We have sent you an email.');
    }

    /** @test */
    public function valid_credentials_should_be_logged_in ()
    {
        $user = create('App\User');

        $response = $this->post('/login',
            [
                'username' => $user->username,
                'password' => 'secret'
            ]
        );

        while ($response->isRedirect()) {
            $response = $this->get($response->headers->get('Location'));
        }

        $response->assertDontSee('Login');
    }
}

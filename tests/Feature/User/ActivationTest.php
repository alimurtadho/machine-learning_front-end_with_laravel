<?php

namespace Tests\Feature\User;

use App\Notifications\SendActivationEmail;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Notification;
use Tests\TestCase;

class ActivationTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function authenticated_users_may_not_verify_account ()
    {
        $this->get('/activation/test')
             ->assertStatus(404);

        $this->signIn()
             ->get('/activation/test')
             ->assertStatus(302);
    }

    /** @test */
    public function activation_token_should_be_sent_during_login ()
    {
        Notification::fake();

        $user = create('App\User', ['activated' => false]);

        $this->post('/login',
            [
                'username' => $user->username,
                'password' => 'secret'
            ]
        );

        Notification::assertSentTo($user, SendActivationEmail::class);
    }

    /** @test */
    public function activation_token_should_be_sent_during_registration ()
    {
        Notification::fake();

        $user = make('App\User');

        $this->post('/register', [
            'name'                  => $user->name,
            'username'              => $user->username,
            'email'                 => $user->email,
            'password'              => 'secret',
            'password_confirmation' => 'secret',
        ]);

        $user = User::findByUsername($user->username);

        $this->assertEquals(0, $user->activated);

        Notification::assertSentTo($user, SendActivationEmail::class);
    }

    /** @test */
    public function valid_token_should_verify_account ()
    {
        $activation = create('App\Activation');
        $email      = $activation->user->email;

        $this->get('/activation/' . $activation->token)
             ->assertSessionHas('success');

        $this->assertDatabaseHas('users', ['email' => $email, 'activated' => true]);
    }

    /** @test */
    public function expired_tokens_should_not_verify_account ()
    {
        $activation = create('App\Activation',
            ['created_at' => Carbon::now()->subHours(config('settings.user.activation.valid_hours') + 1)]);
        $email      = $activation->user->email;

        $this->get('/activation/' . $activation->token)
             ->assertSessionMissing('success');

        $this->assertDatabaseHas('users', ['email' => $email, 'activated' => false]);
    }
}

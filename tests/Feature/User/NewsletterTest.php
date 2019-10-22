<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Newsletter;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function newsletter_should_be_subscribed_on_registration ()
    {
        $email = 'test@example.com';

        Newsletter::shouldReceive('subscribeOrUpdate')
                  ->once()
                  ->with($email)
                  ->andReturn(true);

        $this->post('/register',
            [
                'password'              => 'secret',
                'password_confirmation' => 'secret',
                'email'                 => $email,
            ] + make('App\User')->toArray());
    }

    /** @test */
    public function users_may_subscribe_to_newsletter ()
    {
        $user = create('App\User');

        Newsletter::shouldReceive('subscribeOrUpdate')
                  ->once()
                  ->with($user->email)
                  ->andReturn(true);

        $this->signIn($user);

        $this->put(sprintf('/u/%s/edit', $user->username), $user->fill(['newsletter' => true])->toArray())
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function users_may_un_subscribe_to_newsletter ()
    {
        $user = create('App\User');

        Newsletter::shouldReceive('unsubscribe')
                  ->once()
                  ->with($user->email)
                  ->andReturn(true);

        $this->signIn($user);

        $this->put(sprintf('/u/%s/edit', $user->username), array_except($user->toArray(), 'newsletter'))
             ->assertSessionMissing('errors');
    }
}

<?php

namespace Tests\Feature\User;

use App\Events\UserUpdated;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function user_has_a_profile ()
    {
        $user = create('App\User');

        $this->get(sprintf('/u/%s', $user->username))
             ->assertSee($user->name);
    }

    /** @test */
    public function datasets_must_be_visible_in_profile ()
    {
        $user = create('App\User');

        $datasets = create('App\Dataset', ['user_id' => $user->id], 5);

        $response = $this->get(sprintf('/u/%s', $user->username));

        foreach ($datasets as $dataset) {
            $response->assertSee($dataset->name);
        }
    }

    /** @test */
    public function codes_must_be_visible_in_profile ()
    {
        $user = create('App\User');

        $codes = create('App\Code', ['user_id' => $user->id], 5);

        $response = $this->get(sprintf('/u/%s', $user->username));

        foreach ($codes as $code) {
            $response->assertSee($code->name);
        }
    }

    /** @test */
    public function guests_may_not_update_profile ()
    {
        $user = create('App\User');

        $response = $this->get(sprintf('/u/%s/edit', $user->username));

        $response->assertDontSee($user->email);
    }

    /** @test */
    public function authenticated_users_may_update_own_profile ()
    {
        $this->expectsEvents([UserUpdated::class]);

        $user = create('App\User');
        $this->signIn($user);

        $this->get(sprintf('/u/%s/edit', $user->username))
             ->assertSee($user->email);

        $this->updateProfile($user)->assertSessionMissing('errors');
    }

    /** @test */
    public function authenticated_users_may_not_update_others_profile ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $user2 = create('App\User');

        $this->get(sprintf('/u/%s/edit', $user2->username))
             ->assertSee($user->email)
             ->assertDontSee($user2->email);

        $this->updateProfile($user2->fill(['name' => 'Test']));

        $this->assertDatabaseMissing('users', ['id' => $user2->id, 'name' => 'Test']);
    }

    /** @test */
    public function a_valid_name_is_required_to_update_profile ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->updateProfile($user->fill(['name' => null]))
             ->assertSessionHasErrors('name');

        $this->updateProfile($user->fill(['name' => str_random(300)]))
             ->assertSessionHasErrors('name');
    }

    /** @test */
    public function username_may_not_be_changed_by_user ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->updateProfile($user, ['username' => 'newUsername']);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'username' => $user->username]);
    }

    /** @test */
    public function email_may_not_be_changed_by_user ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->updateProfile($user, ['email' => 'test@example.com']);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => $user->email]);
    }

    /** @test */
    public function a_valid_date_of_birth_is_required_to_update_profile ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->updateProfile($user, ['dob' => 'string'])
             ->assertSessionHasErrors('dob');

        $this->updateProfile($user, ['dob' => Carbon::now()->toDateString()])
             ->assertSessionHasErrors('dob');

        $this->updateProfile($user, ['dob' => Carbon::now()->subYear(15)->toDateString()])
             ->assertSessionHasErrors('dob');

        $this->updateProfile($user, ['dob' => Carbon::now()->subYear(18)->toDateString()])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_valid_occupation_is_required_to_update_profile ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->updateProfile($user, ['occupation' => str_random(300)])
             ->assertSessionHasErrors('occupation');

        $this->updateProfile($user, ['occupation' => 'Developer'])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_valid_github_username_is_required_to_update_profile ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->updateProfile($user, ['github_username' => str_random(300)])
             ->assertSessionHasErrors('github_username');

        $this->updateProfile($user, ['github_username' => 'nikhil-pandey'])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_valid_linkedin_username_is_required_to_update_profile ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->updateProfile($user, ['linkedin_username' => str_random(300)])
             ->assertSessionHasErrors('linkedin_username');

        $this->updateProfile($user, ['linkedin_username' => 'nikhilpan'])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_valid_website_is_required_to_update_profile ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->updateProfile($user, ['website' => str_random(10)])
             ->assertSessionHasErrors('website');

        $this->updateProfile($user, ['website' => 'www.google.com'])
             ->assertSessionHasErrors('website');

        $this->updateProfile($user, ['website' => 'http://www.google.com'])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function a_valid_newsletter_value_is_required_to_update_profile ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->updateProfile($user, ['newsletter' => 'string'])
             ->assertSessionHasErrors('newsletter');

        $this->updateProfile($user, ['newsletter' => true])
             ->assertSessionMissing('errors');
    }

    /** @test */
    public function admin_may_update_any_profile ()
    {
        $this->signIn($this->createAdmin());

        $user = create('App\User');

        $this->get(sprintf('/u/%s/edit', $user->username))
             ->assertSee($user->email);

        $this->updateProfile($user->fill(['name' => 'new name']))
             ->assertSessionMissing('errors');

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'new name']);
    }

    /** @test */
    public function admin_may_change_anyones_username ()
    {
        $this->signIn($this->createAdmin());

        $user = create('App\User');

        $this->updateProfile($user, ['username' => 'newUsername'])
             ->assertSessionMissing('errors');

        $this->assertDatabaseHas('users', ['id' => $user->id, 'username' => 'newUsername']);
    }

    /** @test */
    public function admin_may_change_anyones_email ()
    {
        $this->signIn($this->createAdmin());

        $user = create('App\User');

        $this->updateProfile($user, ['email' => 'test@example.com'])
             ->assertSessionMissing('errors');

        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => 'test@example.com']);
    }

    /** @test */
    public function authenticated_users_may_change_password ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->changePassword($user)->assertSessionMissing('errors');
    }

    /** @test */
    public function a_valid_password_is_required_to_change_password ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->changePassword($user, 'test', 'test')->assertSessionHasErrors('password');
    }

    /** @test */
    public function password_must_be_confirmed_to_change_password ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->changePassword($user, 'password')->assertSessionHasErrors('password');
    }

    protected function updateProfile ($user, $overrides = [])
    {
        return $this->put(sprintf('/u/%s/edit', $user->username), $overrides + $user->toArray());
    }

    protected function changePassword ($user, $password = 'secret', $password_confirmation = 'secret')
    {
        return $this->put(sprintf('/u/%s/password', $user->username), compact('password', 'password_confirmation'));
    }
}

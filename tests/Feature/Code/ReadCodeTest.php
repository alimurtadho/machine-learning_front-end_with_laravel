<?php

namespace Tests\Feature\Dataset;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReadCodeTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $code;

    public function setUp ()
    {
        parent::setUp();
        $this->code = create('App\Code');
    }

    /** @test */
    public function anyone_can_view_published_codes ()
    {
        $this->get('/codes')
             ->assertSee($this->code->name);
    }

    /** @test */
    public function anyone_can_view_trending_codes ()
    {
        $this->signIn();

        $code = create('App\Code', ['created_at' => Carbon::now()->subDays(10)]);
        $code->vote();

        $this->get('/codes?trending=1')
             ->assertDontSee($code->name);

        $code = create('App\Code');
        $code->vote();

        $this->get('/codes?trending=1')
             ->assertSee($code->name);
    }

    /** @test */
    public function anyone_can_view_popular_codes ()
    {
        $this->signIn();

        $codes = create('App\Code', [], 30)->random(3);
        foreach ($codes as $code) {
            $code->vote();
        }

        foreach ($codes as $code) {
            $this->get('/codes?popular=1')
                 ->assertSee($code->name);
        }
    }

    /** @test */
    public function authenticated_users_may_view_their_codes ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $code = create('App\Code');
        $this->get('/codes?author=' . $user->username)
             ->assertDontSee($code->name);

        $code = create('App\Code', ['user_id' => $user->id]);
        $this->get('/codes?author=' . $user->username)
             ->assertSee($code->name);
    }

    /** @test */
    public function unpublished_codes_should_not_be_visible ()
    {
        $code = create('App\Code', ['published' => false]);
        $this->get('/codes')
             ->assertDontSee($code->name);
    }

    /** @test */
    public function trending_codes_should_not_include_unpublished_codes ()
    {
        $this->signIn();

        $code = create('App\Code', ['published' => false]);
        $code->vote();

        $this->get('/codes?trending=1')
             ->assertDontSee($code->name);

        $this->get('/codes?popular=1')
             ->assertDontSee($code->name);
    }

    /** @test */
    public function a_code_must_be_viewable ()
    {
        $this->get($this->code->path())
             ->assertSee($this->code->name);
    }

    /** @test */
    public function users_may_not_view_unpublished_code ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');
        $code = create('App\Code', ['published' => false]);
        $this->disableExceptionHandling()->get($code->path());
    }

    /** @test */
    public function owners_may_view_unpublished_codes ()
    {
        $user = create('App\User');
        $code = create('App\Code', ['published' => false, 'user_id' => $user->id]);

        $this->signIn($user);

        $this->get('/codes')
             ->assertSee($code->name);

        $this->get($code->path())
             ->assertSee($code->name);
    }

    /** @test */
    public function admin_may_view_unpublished_codes ()
    {
        $code = create('App\Code', ['published' => false]);

        $this->signIn($this->createAdmin());

        $this->get($code->path())
             ->assertSee($code->name);
    }

    /** @test */
    public function unpublished_code_should_not_be_listed_under_datasets ()
    {
        $dataset = create('App\Dataset');
        $code    = create('App\Code', ['dataset_id' => $dataset->id]);

        $this->get($dataset->path())
             ->assertSee($code->name);

        $code = create('App\Code', ['dataset_id' => $dataset->id, 'published' => false]);

        $this->get($dataset->path())
             ->assertDontSee($code->name);
    }

    /** @test */
    public function anyone_can_search_for_codes ()
    {
        $code = create('App\Code');
        create('App\Code', [], 30);

        $this->get('/codes?search=' . $code->name)
             ->assertSee($code->name);
    }
}

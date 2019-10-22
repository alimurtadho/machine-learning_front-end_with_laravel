<?php

namespace Tests\Feature\Dataset;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ReadDatasetsTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $dataset;

    public function setUp ()
    {
        parent::setUp();
        $this->dataset = create('App\Dataset');
    }

    /** @test */
    public function anyone_can_view_published_datasets ()
    {
        $this->get('/datasets')
             ->assertSee($this->dataset->name);
    }

    /** @test */
    public function anyone_can_view_featured_datasets ()
    {
        $this->get('/datasets?featured=true')
             ->assertDontSee($this->dataset->name);

        $dataset = create('App\Dataset', ['featured' => true]);
        $this->get('/datasets?featured=true')
             ->assertSee($dataset->name);
    }

    /** @test */
    public function anyone_can_view_trending_datasets ()
    {
        $this->signIn();

        $dataset = create('App\Dataset', ['created_at' => Carbon::now()->subDays(10)]);
        $dataset->vote();

        $this->get('/datasets?trending=1')
             ->assertDontSee($dataset->name);

        $dataset = create('App\Dataset');
        $dataset->vote();

        $this->get('/datasets?trending=1')
             ->assertSee($dataset->name);
    }

    /** @test */
    public function anyone_can_view_popular_datasets ()
    {
        $this->signIn();

        $datasets = create('App\Dataset', [], 30)->random(3);
        foreach ($datasets as $dataset) {
            $dataset->vote();
        }

        foreach ($datasets as $dataset) {
            $this->get('/datasets?popular=1')
                 ->assertSee($dataset->name);
        }
    }

    /** @test */
    public function authenticated_users_may_view_their_datasets ()
    {
        $user = create('App\User');
        $this->signIn($user);

        $dataset = create('App\Dataset');
        $this->get('/datasets?author=' . $user->username)
             ->assertDontSee($dataset->name);

        $dataset = create('App\Dataset', ['user_id' => $user->id]);
        $this->get('/datasets?author=' . $user->username)
             ->assertSee($dataset->name);
    }

    /** @test */
    public function unpublished_datasets_should_not_be_visible ()
    {
        $dataset = create('App\Dataset', ['published' => false]);
        $this->get('/datasets')
             ->assertDontSee($dataset->name);
    }

    /** @test */
    public function unpublished_datasets_should_not_be_listed_under_featured_datasets ()
    {
        $dataset = create('App\Dataset', ['published' => false, 'featured' => true]);
        $this->get('/datasets?featured=true')
             ->assertDontSee($dataset->name);
    }

    /** @test */
    public function unpublished_datasets_should_not_be_listed_under_trending_datasets ()
    {
        $this->signIn();

        $dataset = create('App\Dataset', ['published' => false]);
        $dataset->vote();

        $this->get('/datasets?trending=1')
             ->assertDontSee($dataset->name);
    }

    /** @test */
    public function unpublished_datasets_should_not_be_listed_under_popular_datasets ()
    {
        $this->signIn();

        $dataset = create('App\Dataset', ['published' => false]);
        $dataset->vote();

        $this->get('/datasets?popular=1')
             ->assertDontSee($dataset->name);
    }

    /** @test */
    public function a_dataset_must_be_viewable ()
    {
        $this->get($this->dataset->path())
             ->assertSee($this->dataset->name);
    }

    /** @test */
    public function a_dataset_must_list_all_of_its_codes ()
    {
        $codes = create('App\Code', ['dataset_id' => $this->dataset->id], 5);
        foreach ($codes as $code) {
            $this->get($this->dataset->path())
                 ->assertSee($code->name);
        }
    }

    /** @test */
    public function users_may_not_view_unpublished_dataset ()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');
        $dataset = create('App\Dataset', ['published' => false]);
        $this->disableExceptionHandling()->get($dataset->path());
    }

    /** @test */
    public function owner_may_view_unpublished_datasets ()
    {
        $user    = create('App\User');
        $dataset = create('App\Dataset', ['published' => false, 'user_id' => $user->id]);

        $this->signIn($user);
        $this->get('/datasets')
             ->assertSee($dataset->name);

        $this->get($dataset->path())
             ->assertSee($dataset->name);
    }

    /** @test */
    public function admin_may_view_unpublished_datasets ()
    {
        $dataset = create('App\Dataset', ['published' => false]);

        $this->signIn($this->createAdmin());

        $this->get($dataset->path())
             ->assertSee($dataset->name);
    }

    /** @test */
    public function anyone_can_search_for_datasets ()
    {
        $dataset = create('App\Dataset');
        create('App\Dataset', [], 30);

        $this->get('/datasets?search=' . $dataset->name)
             ->assertSee($dataset->name);
    }
}

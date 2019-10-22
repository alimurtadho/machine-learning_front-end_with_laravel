<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;
    protected $role;

    public function setUp ()
    {
        parent::setUp();
        $this->role = create('App\Role');
        $users      = create('App\User', [], 5);
        foreach ($users as $user) {
            $user->attachRole($this->role);
        }
    }

    /** @test */
    public function a_role_has_many_users ()
    {
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $this->role->users
        );

        foreach ($this->role->users as $user) {
            $this->assertInstanceOf('App\User', $user);
        }
    }
}

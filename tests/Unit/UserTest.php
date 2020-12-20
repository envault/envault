<?php

namespace Tests\Unit;

use App\Models\App;
use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function full_name_determined()
    {
        $user = User::factory()->create();

        $this->assertEquals($user->full_name, $user->first_name.' '.$user->last_name);
    }

    /** @test */
    public function admin_or_owner_status_determined_for_admin()
    {
        $user = User::factory()->state([
            'role' => 'admin',
        ])->create();

        $this->assertTrue($user->isAdminOrOwner());
    }

    /** @test */
    public function admin_or_owner_status_determined_for_owner()
    {
        $user = User::factory()->state([
            'role' => 'owner',
        ])->create();

        $this->assertTrue($user->isAdminOrOwner());
    }

    /** @test */
    public function admin_or_owner_status_determined_for_not_admin_or_owner()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->isAdminOrOwner());
    }

    /** @test */
    public function app_admin_status_determined_for_app_admin()
    {
        $user = User::factory()->create();

        $app = App::factory()->create();

        $app->collaborators()->attach($user, [
            'role' => 'admin',
        ]);

        $this->assertTrue($user->isAppAdmin($app));
    }

    /** @test */
    public function app_admin_status_determined_for_not_app_admin()
    {
        $user = User::factory()->create();

        $app = App::factory()->create();

        $this->assertFalse($user->isAppAdmin($app));

        $app->collaborators()->attach($user);

        $this->assertFalse($user->isAppAdmin($app));
    }

    /** @test */
    public function app_collabortator_status_determined_for_app_collabortator()
    {
        $user = User::factory()->create();

        $app = App::factory()->create();

        $app->collaborators()->attach($user);

        $this->assertTrue($user->isAppCollaborator($app));
    }

    /** @test */
    public function app_collabortator_status_determined_for_not_app_collabortator()
    {
        $user = User::factory()->create();

        $app = App::factory()->create();

        $this->assertFalse($user->isAppCollaborator($app));
    }

    /** @test */
    public function owner_status_determined_for_owner()
    {
        $user = User::factory()->state([
            'role' => 'owner',
        ])->create();

        $this->assertTrue($user->isOwner());
    }

    /** @test */
    public function owner_status_determined_for_not_owner()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->isOwner());
    }
}

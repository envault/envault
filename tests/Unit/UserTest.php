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
        $user = factory(User::class)->create();

        $this->assertEquals($user->full_name, $user->first_name.' '.$user->last_name);
    }

    /** @test */
    public function admin_or_owner_status_determined_for_admin()
    {
        $user = factory(User::class)->create([
            'role' => 'admin',
        ]);

        $this->assertTrue($user->isAdminOrOwner());
    }

    /** @test */
    public function admin_or_owner_status_determined_for_owner()
    {
        $user = factory(User::class)->create([
            'role' => 'owner',
        ]);

        $this->assertTrue($user->isAdminOrOwner());
    }

    /** @test */
    public function admin_or_owner_status_determined_for_not_admin_or_owner()
    {
        $user = factory(User::class)->create();

        $this->assertFalse($user->isAdminOrOwner());
    }

    /** @test */
    public function app_admin_status_determined_for_app_admin()
    {
        $user = factory(User::class)->create();

        $app = factory(App::class)->create();

        $app->collaborators()->attach($user, [
            'role' => 'admin',
        ]);

        $this->assertTrue($user->isAppAdmin($app));
    }

    /** @test */
    public function app_admin_status_determined_for_not_app_admin()
    {
        $user = factory(User::class)->create();

        $app = factory(App::class)->create();

        $this->assertFalse($user->isAppAdmin($app));

        $app->collaborators()->attach($user);

        $this->assertFalse($user->isAppAdmin($app));
    }

    /** @test */
    public function app_collabortator_status_determined_for_app_collabortator()
    {
        $user = factory(User::class)->create();

        $app = factory(App::class)->create();

        $app->collaborators()->attach($user);

        $this->assertTrue($user->isAppCollaborator($app));
    }

    /** @test */
    public function app_collabortator_status_determined_for_not_app_collabortator()
    {
        $user = factory(User::class)->create();

        $app = factory(App::class)->create();

        $this->assertFalse($user->isAppCollaborator($app));
    }

    /** @test */
    public function owner_status_determined_for_owner()
    {
        $user = factory(User::class)->create([
            'role' => 'owner',
        ]);

        $this->assertTrue($user->isOwner());
    }

    /** @test */
    public function owner_status_determined_for_not_owner()
    {
        $user = factory(User::class)->create();

        $this->assertFalse($user->isOwner());
    }
}

<?php

namespace Tests\Unit\Policies;

use App\App;
use App\Policies\AppPolicy;
use App\User;
use Tests\TestCase;

class AppPolicyTest extends TestCase
{
    /** @test */
    public function admin_or_owner_can_create_app()
    {
        $user = factory(User::class)->create([
            'role' => 'admin',
        ]);

        $this->assertTrue((new AppPolicy)->create($user));

        $user->role = 'owner';

        $this->assertTrue((new AppPolicy)->create($user));
    }

    /** @test */
    public function not_admin_or_owner_cant_create_app()
    {
        $user = factory(User::class)->create();

        $this->assertFalse((new AppPolicy)->create($user));
    }

    /** @test */
    public function admin_or_owner_can_create_variables()
    {
        $appToCreateVariablesFor = factory(App::class)->create();

        $user = factory(User::class)->create([
            'role' => 'admin',
        ]);

        $this->assertTrue((new AppPolicy)->createVariable($user, $appToCreateVariablesFor));

        $user->role = 'owner';

        $this->assertTrue((new AppPolicy)->createVariable($user, $appToCreateVariablesFor));
    }

    /** @test */
    public function app_admin_can_create_variables()
    {
        $appToCreateVariablesFor = factory(App::class)->create();

        $user = factory(User::class)->create();

        $appToCreateVariablesFor->collaborators()->attach($user, [
            'role' => 'admin',
        ]);

        $this->assertTrue((new AppPolicy)->createVariable($user, $appToCreateVariablesFor));
    }

    /** @test */
    public function not_admin_or_owner_or_app_admin_cant_create_variables()
    {
        $appToCreateVariablesFor = factory(App::class)->create();

        $user = factory(User::class)->create();

        $this->assertFalse((new AppPolicy)->createVariable($user, $appToCreateVariablesFor));

        $appToCreateVariablesFor->collaborators()->attach($user);

        $this->assertFalse((new AppPolicy)->createVariable($user, $appToCreateVariablesFor));
    }

    /** @test */
    public function admin_or_owner_can_delete_app()
    {
        $appToDelete = factory(App::class)->create();

        $user = factory(User::class)->create([
            'role' => 'admin',
        ]);

        $this->assertTrue((new AppPolicy)->delete($user, $appToDelete));

        $user->role = 'owner';

        $this->assertTrue((new AppPolicy)->delete($user, $appToDelete));
    }

    /** @test */
    public function not_admin_or_owner_cant_delete_app()
    {
        $appToDelete = factory(App::class)->create();

        $user = factory(User::class)->create();

        $this->assertFalse((new AppPolicy)->delete($user, $appToDelete));
    }

    /** @test */
    public function owner_can_force_delete_app()
    {
        $appToForceDelete = factory(App::class)->create();

        $user = factory(User::class)->create([
            'role' => 'owner',
        ]);

        $this->assertTrue((new AppPolicy)->forceDelete($user, $appToForceDelete));
    }

    /** @test */
    public function not_owner_cant_force_delete_app()
    {
        $appToForceDelete = factory(App::class)->create();

        $user = factory(User::class)->create();

        $this->assertFalse((new AppPolicy)->forceDelete($user, $appToForceDelete));

        $user->role = 'admin';

        $this->assertFalse((new AppPolicy)->forceDelete($user, $appToForceDelete));
    }

    /** @test */
    public function admin_or_owner_can_restore_app()
    {
        $appToRestore = factory(App::class)->create();

        $user = factory(User::class)->create([
            'role' => 'admin',
        ]);

        $this->assertTrue((new AppPolicy)->restore($user, $appToRestore));

        $user->role = 'owner';

        $this->assertTrue((new AppPolicy)->restore($user, $appToRestore));
    }

    /** @test */
    public function not_admin_or_owner_cant_restore_app()
    {
        $appToRestore = factory(App::class)->create();

        $user = factory(User::class)->create();

        $this->assertFalse((new AppPolicy)->restore($user, $appToRestore));
    }

    /** @test */
    public function admin_or_owner_can_update_app()
    {
        $appToUpdate = factory(App::class)->create();

        $user = factory(User::class)->create([
            'role' => 'admin',
        ]);

        $this->assertTrue((new AppPolicy)->update($user, $appToUpdate));

        $user->role = 'owner';

        $this->assertTrue((new AppPolicy)->update($user, $appToUpdate));
    }

    /** @test */
    public function not_admin_or_owner_cant_update_app()
    {
        $appToUpdate = factory(App::class)->create();

        $user = factory(User::class)->create();

        $this->assertFalse((new AppPolicy)->update($user, $appToUpdate));
    }

    /** @test */
    public function admin_or_owner_can_view_app()
    {
        $appToView = factory(App::class)->create();

        $user = factory(User::class)->create([
            'role' => 'admin',
        ]);

        $this->assertTrue((new AppPolicy)->view($user, $appToView));

        $user->role = 'owner';

        $this->assertTrue((new AppPolicy)->view($user, $appToView));
    }

    /** @test */
    public function app_collaborator_can_view_app()
    {
        $appToView = factory(App::class)->create();

        $user = factory(User::class)->create();

        $appToView->collaborators()->attach($user);

        $this->assertTrue((new AppPolicy)->view($user, $appToView));
    }

    /** @test */
    public function not_admin_or_owner_or_app_collaborator_cant_view_app()
    {
        $appToView = factory(App::class)->create();

        $user = factory(User::class)->create();

        $this->assertFalse((new AppPolicy)->view($user, $appToView));
    }

    /** @test */
    public function admin_or_owner_can_view_all_app()
    {
        $user = factory(User::class)->create([
            'role' => 'admin',
        ]);

        $this->assertTrue((new AppPolicy)->viewAll($user));

        $user->role = 'owner';

        $this->assertTrue((new AppPolicy)->viewAll($user));
    }

    /** @test */
    public function not_admin_or_owner_cant_view_all_apps()
    {
        $user = factory(User::class)->create();

        $this->assertFalse((new AppPolicy)->viewAll($user));
    }
}

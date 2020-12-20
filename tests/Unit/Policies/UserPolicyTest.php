<?php

namespace Tests\Unit\Policies;

use App\Models\User;
use App\Policies\UserPolicy;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    /** @test */
    public function admin_or_owner_can_create_user()
    {
        $user = User::factory()->state([
            'role' => 'admin',
        ])->create();

        $this->assertTrue((new UserPolicy)->create($user));

        $user->role = 'owner';

        $this->assertTrue((new UserPolicy)->create($user));
    }

    /** @test */
    public function not_admin_or_owner_cant_create_user()
    {
        $user = User::factory()->create();

        $this->assertFalse((new UserPolicy)->create($user));
    }

    /** @test */
    public function owner_can_delete_user()
    {
        $userToDelete = User::factory()->create();

        $user = User::factory()->state([
            'role' => 'owner',
        ])->create();

        $this->assertTrue((new UserPolicy)->delete($user, $userToDelete));
    }

    /** @test */
    public function owner_cant_delete_themselves()
    {
        $user = User::factory()->state([
            'role' => 'owner',
        ])->create();

        $this->assertFalse((new UserPolicy)->delete($user, $user));
    }

    /** @test */
    public function admin_or_owner_can_delete_user_if_not_admin_or_owner()
    {
        $userToDelete = User::factory()->create();

        $user = User::factory()->state([
            'role' => 'admin',
        ])->create();

        $this->assertTrue((new UserPolicy)->delete($user, $userToDelete));

        $user->role = 'owner';

        $this->assertTrue((new UserPolicy)->delete($user, $userToDelete));
    }

    /** @test */
    public function not_admin_or_owner_cant_delete_users()
    {
        $userToDelete = User::factory()->create();

        $user = User::factory()->create();

        $this->assertFalse((new UserPolicy)->delete($user, $userToDelete));
    }

    /** @test */
    public function owner_can_update_user()
    {
        $userToUpdate = User::factory()->create();

        $user = User::factory()->state([
            'role' => 'owner',
        ])->create();

        $this->assertTrue((new UserPolicy)->update($user, $userToUpdate));
    }

    /** @test */
    public function admin_or_owner_can_update_user_if_not_admin_or_owner()
    {
        $userToUpdate = User::factory()->create();

        $user = User::factory()->state([
            'role' => 'admin',
        ])->create();

        $this->assertTrue((new UserPolicy)->update($user, $userToUpdate));

        $user->role = 'owner';

        $this->assertTrue((new UserPolicy)->update($user, $userToUpdate));
    }

    /** @test */
    public function not_admin_or_owner_cant_update_users()
    {
        $userToUpdate = User::factory()->create();

        $user = User::factory()->create();

        $this->assertFalse((new UserPolicy)->update($user, $userToUpdate));
    }

    /** @test */
    public function owner_can_update_user_role()
    {
        $userToUpdate = User::factory()->create();

        $user = User::factory()->state([
            'role' => 'owner',
        ])->create();

        $this->assertTrue((new UserPolicy)->updateRole($user, $userToUpdate));
    }

    /** @test */
    public function owner_cant_update_their_own_role()
    {
        $user = User::factory()->state([
            'role' => 'owner',
        ])->create();

        $this->assertFalse((new UserPolicy)->updateRole($user, $user));
    }

    /** @test */
    public function not_owner_cant_update_user_role()
    {
        $userToUpdate = User::factory()->create();

        $user = User::factory()->create();

        $this->assertFalse((new UserPolicy)->updateRole($user, $userToUpdate));

        $user->role = 'admin';

        $this->assertFalse((new UserPolicy)->updateRole($user, $userToUpdate));
    }

    /** @test */
    public function admin_or_owner_can_view_user()
    {
        $userToView = User::factory()->create();

        $user = User::factory()->state([
            'role' => 'admin',
        ])->create();

        $this->assertTrue((new UserPolicy)->view($user, $userToView));

        $user->role = 'owner';

        $this->assertTrue((new UserPolicy)->view($user, $userToView));
    }

    /** @test */
    public function not_admin_or_owner_cant_view_user()
    {
        $userToView = User::factory()->create();

        $user = User::factory()->create();

        $this->assertFalse((new UserPolicy)->view($user, $userToView));
    }

    /** @test */
    public function admin_or_owner_can_view_any_users()
    {
        $user = User::factory()->state([
            'role' => 'admin',
        ])->create();

        $this->assertTrue((new UserPolicy)->viewAny($user));

        $user->role = 'owner';

        $this->assertTrue((new UserPolicy)->viewAny($user));
    }

    /** @test */
    public function not_admin_or_owner_cant_view_any_users()
    {
        $user = User::factory()->create();

        $this->assertFalse((new UserPolicy)->viewAny($user));
    }
}

<?php

namespace Tests\Unit\Policies;

use App\Models\App;
use App\Models\User;
use App\Models\Variable;
use App\Policies\VariablePolicy;
use Tests\TestCase;

class VariablePolicyTest extends TestCase
{
    /** @test */
    public function admin_or_owner_can_delete_variables()
    {
        $app = App::factory()->create();

        $variableToDelete = $app->variables()->create(Variable::factory()->make()->toArray());

        $user = User::factory()->state([
            'role' => 'admin',
        ])->create();

        $this->assertTrue((new VariablePolicy)->delete($user, $variableToDelete));

        $user->role = 'owner';

        $this->assertTrue((new VariablePolicy)->delete($user, $variableToDelete));
    }

    /** @test */
    public function app_admin_can_delete_variables()
    {
        $app = App::factory()->create();

        $variableToDelete = $app->variables()->create(Variable::factory()->make()->toArray());

        $user = User::factory()->create();

        $app->collaborators()->attach($user, [
            'role' => 'admin',
        ]);

        $this->assertTrue((new VariablePolicy)->delete($user, $variableToDelete));
    }

    /** @test */
    public function not_admin_or_owner_or_app_admin_cant_delete_variables()
    {
        $app = App::factory()->create();

        $variableToDelete = $app->variables()->create(Variable::factory()->make()->toArray());

        $user = User::factory()->create();

        $this->assertFalse((new VariablePolicy)->delete($user, $variableToDelete));

        $app->collaborators()->attach($user);

        $this->assertFalse((new VariablePolicy)->delete($user, $variableToDelete));
    }

    /** @test */
    public function admin_or_owner_can_update_variables()
    {
        $app = App::factory()->create();

        $variableToUpdate = $app->variables()->create(Variable::factory()->make()->toArray());

        $user = User::factory()->state([
            'role' => 'admin',
        ])->create();

        $this->assertTrue((new VariablePolicy)->update($user, $variableToUpdate));

        $user->role = 'owner';

        $this->assertTrue((new VariablePolicy)->update($user, $variableToUpdate));
    }

    /** @test */
    public function app_admin_can_update_variables()
    {
        $app = App::factory()->create();

        $variableToUpdate = $app->variables()->create(Variable::factory()->make()->toArray());

        $user = User::factory()->create();

        $app->collaborators()->attach($user, [
            'role' => 'admin',
        ]);

        $this->assertTrue((new VariablePolicy)->update($user, $variableToUpdate));
    }

    /** @test */
    public function not_admin_or_owner_or_app_admin_cant_update_variables()
    {
        $app = App::factory()->create();

        $variableToUpdate = $app->variables()->create(Variable::factory()->make()->toArray());

        $user = User::factory()->create();

        $this->assertFalse((new VariablePolicy)->update($user, $variableToUpdate));

        $app->collaborators()->attach($user);

        $this->assertFalse((new VariablePolicy)->update($user, $variableToUpdate));
    }

    /** @test */
    public function admin_or_owner_can_view_variable()
    {
        $app = App::factory()->create();

        $variableToView = $app->variables()->create(Variable::factory()->make()->toArray());

        $user = User::factory()->state([
            'role' => 'admin',
        ])->create();

        $this->assertTrue((new VariablePolicy)->view($user, $variableToView));

        $user->role = 'owner';

        $this->assertTrue((new VariablePolicy)->view($user, $variableToView));
    }

    /** @test */
    public function app_collaborator_can_view_variable()
    {
        $app = App::factory()->create();

        $variableToView = $app->variables()->create(Variable::factory()->make()->toArray());

        $user = User::factory()->create();

        $app->collaborators()->attach($user);

        $this->assertTrue((new VariablePolicy)->view($user, $variableToView));
    }

    /** @test */
    public function not_admin_or_owner_or_app_collaborator_cant_view_variable()
    {
        $app = App::factory()->create();

        $variableToView = $app->variables()->create(Variable::factory()->make()->toArray());

        $user = User::factory()->create();

        $this->assertFalse((new VariablePolicy)->view($user, $variableToView));
    }
}

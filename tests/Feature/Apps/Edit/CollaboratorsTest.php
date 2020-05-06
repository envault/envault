<?php

namespace Tests\Feature\Apps\Edit;

use App\App;
use App\User;
use Livewire\Livewire;
use Tests\TestCase;

class CollaboratorsTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_add_user_as_collaborator()
    {
        $app = factory(App::class)->create();

        $userToAdd = factory(User::class)->create();

        Livewire::test('apps.edit.collaborators', ['app' => $app])
            ->set('userToAddId', $userToAdd->id)
            ->call('add')
            ->assertEmitted('app.collaborator.added', $userToAdd->id, $app->id);

        $this->assertDatabaseHas('app_collaborators', [
            'app_id' => $app->id,
            'user_id' => $userToAdd->id,
        ]);
    }

    /** @test */
    public function can_remove_user_from_collaborator()
    {
        $app = factory(App::class)->create();

        $userToRemove = factory(User::class)->create();

        $app->collaborators()->attach($userToRemove);

        Livewire::test('apps.edit.collaborators', ['app' => $app])
            ->call('remove', $userToRemove->id)
            ->assertEmitted('app.collaborator.removed', $userToRemove->id, $app->id);

        $this->assertDeleted('app_collaborators', [
            'app_id' => $app->id,
            'user_id' => $userToRemove->id,
        ]);
    }

    /** @test */
    public function can_select_addable_users()
    {
        $app = factory(App::class)->create();

        $addableUser = factory(User::class)->create();

        Livewire::test('apps.edit.collaborators', ['app' => $app])
            ->assertSee($addableUser->name);
    }

    /** @test */
    public function can_update_collaborator_role()
    {
        $app = factory(App::class)->create();

        $collaboratorToUpdate = factory(User::class)->create();

        $app->collaborators()->attach($collaboratorToUpdate);

        Livewire::test('apps.edit.collaborators', ['app' => $app])
            ->call('updateRole', $collaboratorToUpdate->id, 'admin')
            ->assertEmitted('app.collaborator.updated', $collaboratorToUpdate->id, $app->id);

        $this->assertDatabaseHas('app_collaborators', [
            'app_id' => $app->id,
            'role' => 'admin',
            'user_id' => $collaboratorToUpdate->id,
        ]);
    }

    /** @test */
    public function can_view_collaborators()
    {
        $app = factory(App::class)->create();

        $appCollaborator = factory(User::class)->create();

        $app->collaborators()->attach($appCollaborator);

        Livewire::test('apps.edit.collaborators', ['app' => $app])
            ->assertSee($appCollaborator->name)
            ->assertSee($this->authenticatedUser->name);
    }

    /** @test */
    public function user_to_add_exists()
    {
        $app = factory(App::class)->create();

        Livewire::test('apps.edit.collaborators', ['app' => $app])
            ->set('userToAddId', 2)
            ->call('add')
            ->assertHasErrors(['userToAddId' => 'exists']);
    }

    /** @test */
    public function user_to_add_id_is_required()
    {
        $app = factory(App::class)->create();

        Livewire::test('apps.edit.collaborators', ['app' => $app])
            ->set('userToAddId', null)
            ->call('add')
            ->assertHasErrors(['userToAddId' => 'required']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticatedUser = factory(User::class)->create([
            'role' => 'owner',
        ]);

        Livewire::actingAs($this->authenticatedUser);
    }
}

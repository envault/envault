<?php

namespace Tests\Feature\Apps\Edit;

use App\Models\App;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class DetailsTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_delete_app()
    {
        $appToDelete = App::factory()->create();

        Livewire::test('apps.edit.details', ['app' => $appToDelete])
            ->call('destroy')
            ->assertEmitted('app.deleted', $appToDelete->id);

        $this->assertSoftDeleted('apps', [
            'id' => $appToDelete->id,
        ]);
    }

    /** @test */
    public function can_update_details()
    {
        $appToUpdate = App::factory()->create();

        $newDetails = App::factory()->make();

        Livewire::test('apps.edit.details', ['app' => $appToUpdate])
            ->set('name', $newDetails->name)
            ->call('update')
            ->assertEmitted('app.updated', $appToUpdate->id);

        $this->assertDatabaseHas('apps', [
            'id' => $appToUpdate->id,
            'name' => $newDetails->name,
        ]);
    }

    /** @test */
    public function name_is_required()
    {
        $appToUpdate = App::factory()->create();

        Livewire::test('apps.edit.details', ['app' => $appToUpdate])
            ->set('name', null)
            ->call('update')
            ->assertHasErrors(['name' => 'required']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticatedUser = User::factory()->state([
            'role' => 'owner',
        ])->create();

        Livewire::actingAs($this->authenticatedUser);
    }
}

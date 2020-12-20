<?php

namespace Tests\Feature\Apps;

use App\Models\App;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_create_app()
    {
        $appToCreate = App::factory()->make();

        Livewire::test('apps.create')
            ->set('name', $appToCreate->name)
            ->call('store')
            ->assertEmitted('app.created');

        $this->assertDatabaseHas('apps', [
            'name' => $appToCreate->name,
        ]);
    }

    /** @test */
    public function name_is_required()
    {
        Livewire::test('apps.create')
            ->call('store')
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

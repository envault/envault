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
        $appToCreate = factory(App::class)->make();

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

        $this->authenticatedUser = factory(User::class)->create([
            'role' => 'owner',
        ]);

        Livewire::actingAs($this->authenticatedUser);
    }
}

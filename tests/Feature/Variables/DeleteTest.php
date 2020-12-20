<?php

namespace Tests\Feature\Variables;

use App\Models\App;
use App\Models\User;
use App\Models\Variable;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_delete_variable()
    {
        $app = App::factory()->create();

        $variableToDelete = $app->variables()->create(Variable::factory()->make()->toArray());

        Livewire::test('variables.delete', ['variable' => $variableToDelete])
            ->call('destroy')
            ->assertEmitted('variable.deleted');

        $this->assertSoftDeleted('variables', [
            'id' => $variableToDelete->id,
        ]);
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

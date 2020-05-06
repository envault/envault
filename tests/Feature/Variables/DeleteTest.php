<?php

namespace Tests\Feature\Variables;

use App\App;
use App\User;
use App\Variable;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_delete_variable()
    {
        $app = factory(App::class)->create();

        $variableToDelete = $app->variables()->create(factory(Variable::class)->make()->toArray());

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

        $this->authenticatedUser = factory(User::class)->create([
            'role' => 'owner',
        ]);

        Livewire::actingAs($this->authenticatedUser);
    }
}

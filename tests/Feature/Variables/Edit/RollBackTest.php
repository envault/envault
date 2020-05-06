<?php

namespace Tests\Feature\Variables\Edit;

use App\App;
use App\User;
use App\Variable;
use Livewire\Livewire;
use Tests\TestCase;

class RollBackTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_select_version_to_roll_back_to()
    {
        $app = factory(App::class)->create();

        $variableToSelectVersionOf = $app->variables()->create(factory(Variable::class)->make()->toArray());

        Livewire::test('variables.edit.roll-back', ['variable' => $variableToSelectVersionOf])
            ->set('selectedVersionId', 1)
            ->call('selectVersion', 2, 'value', 'createdAt')
            ->assertSet('selectedVersionCreatedAt', 'createdAt')
            ->assertSet('selectedVersionId', 2)
            ->assertSet('selectedVersionValue', 'value')
            ->assertEmitted('variable.version.selected');

        Livewire::test('variables.edit.roll-back', ['variable' => $variableToSelectVersionOf])
            ->set('selectedVersionId', 1)
            ->call('selectVersion', 1, 'value', 'createdAt')
            ->assertSet('selectedVersionCreatedAt', null)
            ->assertSet('selectedVersionId', null)
            ->assertSet('selectedVersionValue', null)
            ->assertEmitted('variable.version.deselected');
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

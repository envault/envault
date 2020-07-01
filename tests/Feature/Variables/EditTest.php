<?php

namespace Tests\Feature\Variables;

use App\Models\App;
use App\Models\User;
use App\Models\Variable;
use App\Models\VariableVersion;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_restore_variable_version()
    {
        $app = factory(App::class)->create();

        $variableToRestoreVersionOf = $app->variables()->create(factory(Variable::class)->make()->toArray());

        $newVersionDetails = factory(VariableVersion::class)->make();

        Livewire::test('variables.edit', ['variable' => $variableToRestoreVersionOf])
            ->set('value', null)
            ->set('openRollBack', true)
            ->call('restoreVersion', $newVersionDetails->value)
            ->assertSet('value', $newVersionDetails->value)
            ->assertSet('openRollBack', false)
            ->assertEmitted('variable.version.restored');
    }

    /** @test */
    public function can_toggle_open_roll_back_from_closed_to_open()
    {
        $app = factory(App::class)->create();

        $variableToOpenRollBackOf = $app->variables()->create(factory(Variable::class)->make()->toArray());

        Livewire::test('variables.edit', ['variable' => $variableToOpenRollBackOf])
            ->set('openRollBack', false)
            ->call('toggleOpenRollBack')
            ->assertSet('openRollBack', true)
            ->assertEmitted('variable.roll-back.opened');
    }

    /** @test */
    public function can_toggle_open_roll_back_from_open_to_closed()
    {
        $app = factory(App::class)->create();

        $variableToCloseRollBackOf = $app->variables()->create(factory(Variable::class)->make()->toArray());

        Livewire::test('variables.edit', ['variable' => $variableToCloseRollBackOf])
            ->set('openRollBack', true)
            ->call('toggleOpenRollBack')
            ->assertSet('openRollBack', false)
            ->assertEmitted('variable.roll-back.closed');
    }

    /** @test */
    public function can_update_variable()
    {
        $app = factory(App::class)->create();

        $variableToUpdate = $app->variables()->create(factory(Variable::class)->make()->toArray());

        $newVariableDetails = factory(Variable::class)->make();

        $newVariableVersionDetails = factory(VariableVersion::class)->make();

        Livewire::test('variables.edit', ['variable' => $variableToUpdate])
            ->set('key', $newVariableDetails->key)
            ->set('value', $newVariableVersionDetails->value)
            ->call('update')
            ->assertEmitted('variable.updated');

        $this->assertDatabaseHas('variables', [
            'app_id' => $app->id,
            'key' => $newVariableDetails->key,
        ]);

        $this->assertEquals(Variable::where([
            ['app_id', $app->id],
            ['key', $newVariableDetails->key],
        ])->first()->latest_version->value, $newVariableVersionDetails->value);
    }

    /** @test */
    public function key_is_alpha_dash()
    {
        $app = factory(App::class)->create();

        $variableToUpdate = $app->variables()->create(factory(Variable::class)->make()->toArray());

        Livewire::test('variables.edit', ['variable' => $variableToUpdate])
            ->set('key', $this->faker->sentence)
            ->call('update')
            ->assertHasErrors(['key' => 'alpha_dash']);
    }

    /** @test */
    public function key_is_required()
    {
        $app = factory(App::class)->create();

        $variableToUpdate = $app->variables()->create(factory(Variable::class)->make()->toArray());

        Livewire::test('variables.edit', ['variable' => $variableToUpdate])
            ->set('key', null)
            ->call('update')
            ->assertHasErrors(['key' => 'required']);
    }

    /** @test */
    public function key_is_app_unique()
    {
        $app = factory(App::class)->create();

        $variable = $app->variables()->create(factory(Variable::class)->make()->toArray());

        $variableToUpdate = $app->variables()->create(factory(Variable::class)->make()->toArray());

        Livewire::test('variables.edit', ['variable' => $variableToUpdate])
            ->set('key', $variable->key)
            ->call('update')
            ->assertHasErrors(['key' => 'unique']);

        $variableBelongingToDifferentApp = factory(App::class)->create()->variables()->create(factory(Variable::class)->make()->toArray());

        Livewire::test('variables.edit', ['variable' => $variableToUpdate])
            ->set('key', $variableBelongingToDifferentApp->key)
            ->call('update')
            ->assertHasNoErrors('key');
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

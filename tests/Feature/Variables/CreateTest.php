<?php

namespace Tests\Feature\Variables;

use App\Models\App;
use App\Models\User;
use App\Models\Variable;
use App\Models\VariableVersion;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_create_variable()
    {
        $app = App::factory()->create();

        $variableToCreate = Variable::factory()->make();

        $variableVersionToCreate = VariableVersion::factory()->make();

        Livewire::test('variables.create', ['app' => $app])
            ->set('key', $variableToCreate->key)
            ->set('value', $variableVersionToCreate->value)
            ->call('store')
            ->assertEmitted('variable.created')
            ->assertSet('key', null)
            ->assertSet('value', null);

        $this->assertDatabaseHas('variables', [
            'app_id' => $app->id,
            'key' => $variableToCreate->key,
        ]);

        $this->assertEquals(Variable::where([
            ['app_id', $app->id],
            ['key', $variableToCreate->key],
        ])->first()->latest_version->value, $variableVersionToCreate->value);
    }

    /** @test */
    public function can_import_variable()
    {
        $app = App::factory()->create();

        $variableToCreate = Variable::factory()->make();

        $variableVersionToCreate = VariableVersion::factory()->make();

        Livewire::test('variables.create', ['app' => $app])
            ->set('import', $variableToCreate->key.'='.$variableVersionToCreate->value)
            ->call('import')
            ->assertEmitted('variables.imported')
            ->assertSet('key', null)
            ->assertSet('import', null);

        $this->assertDatabaseHas('variables', [
            'app_id' => $app->id,
            'key' => $variableToCreate->key,
        ]);

        $this->assertEquals(Variable::where([
            ['app_id', $app->id],
            ['key', $variableToCreate->key],
        ])->first()->latest_version->value, $variableVersionToCreate->value);
    }

    /** @test */
    public function key_is_alpha_dash()
    {
        $app = App::factory()->create();

        Livewire::test('variables.create', ['app' => $app])
            ->set('key', $this->faker->sentence)
            ->call('store')
            ->assertHasErrors(['key' => 'alpha_dash']);
    }

    /** @test */
    public function key_is_required()
    {
        $app = App::factory()->create();

        Livewire::test('variables.create', ['app' => $app])
            ->call('store')
            ->assertHasErrors(['key' => 'required']);
    }

    /** @test */
    public function key_is_app_unique()
    {
        $app = App::factory()->create();

        $variable = $app->variables()->create(Variable::factory()->make()->toArray());

        Livewire::test('variables.create', ['app' => $app])
            ->set('key', $variable->key)
            ->call('store')
            ->assertHasErrors(['key' => 'unique']);

        $variableBelongingToDifferentApp = App::factory()->create()->variables()->create(Variable::factory()->make()->toArray());

        Livewire::test('variables.create', ['app' => $app])
            ->set('key', $variableBelongingToDifferentApp->key)
            ->call('store')
            ->assertHasNoErrors('key');
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

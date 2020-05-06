<?php

namespace Tests\Feature\Variables;

use App\App;
use App\User;
use App\Variable;
use App\VariableVersion;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_create_variable()
    {
        $app = factory(App::class)->create();

        $variableToCreate = factory(Variable::class)->make();

        $variableVersionToCreate = factory(VariableVersion::class)->make();

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
        $app = factory(App::class)->create();

        $variableToCreate = factory(Variable::class)->make();

        $variableVersionToCreate = factory(VariableVersion::class)->make();

        Livewire::test('variables.create', ['app' => $app])
            ->set('variables', $variableToCreate->key.'='.$variableVersionToCreate->value)
            ->call('import')
            ->assertEmitted('variables.created')
            ->assertSet('key', null)
            ->assertSet('variables', null);

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
        $app = factory(App::class)->create();

        Livewire::test('variables.create', ['app' => $app])
            ->set('key', $this->faker->sentence)
            ->call('store')
            ->assertHasErrors(['key' => 'alpha_dash']);
    }

    /** @test */
    public function key_is_required()
    {
        $app = factory(App::class)->create();

        Livewire::test('variables.create', ['app' => $app])
            ->call('store')
            ->assertHasErrors(['key' => 'required']);
    }

    /** @test */
    public function key_is_app_unique()
    {
        $app = factory(App::class)->create();

        $variable = $app->variables()->create(factory(Variable::class)->make()->toArray());

        Livewire::test('variables.create', ['app' => $app])
            ->set('key', $variable->key)
            ->call('store')
            ->assertHasErrors(['key' => 'unique']);

        $variableBelongingToDifferentApp = factory(App::class)->create()->variables()->create(factory(Variable::class)->make()->toArray());

        Livewire::test('variables.create', ['app' => $app])
            ->set('key', $variableBelongingToDifferentApp->key)
            ->call('store')
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

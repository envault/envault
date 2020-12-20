<?php

namespace Tests\Feature\Variables;

use App\Models\App;
use App\Models\User;
use App\Models\Variable;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    protected $app;

    protected $authenticatedUser;

    /** @test */
    public function can_view_variables()
    {
        $app = App::factory()->create();

        $variableToView = $app->variables()->create(Variable::factory()->make()->toArray());

        Livewire::test('variables.index', ['app' => $app])
            ->assertSee($variableToView->key);
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

<?php

namespace Tests\Feature\Variables;

use App\App;
use App\User;
use App\Variable;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    protected $app;

    protected $authenticatedUser;

    /** @test */
    public function can_view_variables()
    {
        $app = factory(App::class)->create();

        $variableToView = $app->variables()->create(factory(Variable::class)->make()->toArray());

        Livewire::test('variables.index', ['app' => $app])
            ->assertSee($variableToView->key);
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

<?php

namespace Tests\Feature\Apps;

use App\Models\App;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_search_apps()
    {
        $app = App::factory()->count(20)->create()->random();

        Livewire::test('apps.index')
            ->set('search', $app->name)
            ->assertSee($app->name);
    }

    /** @test */
    public function can_view_apps()
    {
        $app = App::factory()->create();

        Livewire::test('apps.index')
            ->assertSee($app->name);
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

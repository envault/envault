<?php

namespace Tests\Feature\Apps;

use App\App;
use App\User;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_search_apps()
    {
        $app = factory(App::class, 20)->create()->random();

        Livewire::test('apps.index')
            ->set('search', $app->name)
            ->assertSee($app->name);
    }

    /** @test */
    public function can_view_apps()
    {
        $app = factory(App::class)->create();

        Livewire::test('apps.index')
            ->assertSee($app->name);
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

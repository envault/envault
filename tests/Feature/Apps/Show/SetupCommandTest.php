<?php

namespace Tests\Feature\Apps\Show;

use App\Models\App;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class SetupCommandTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_generate_and_view_setup_command()
    {
        $app = App::factory()->create();

        Livewire::test('apps.show.setup-command', ['app' => $app])
            ->assertNotSet('token', null)
            ->assertEmitted('app.setup-command.generated', $app->id);

        $this->assertDatabaseHas('app_setup_tokens', [
            'app_id' => $app->id,
            'user_id' => $this->authenticatedUser->id,
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

<?php

namespace Tests\Feature\Apps\Show;

use App\App;
use App\User;
use Livewire\Livewire;
use Tests\TestCase;

class SetupCommandTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_generate_and_view_setup_command()
    {
        $app = factory(App::class)->create();

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

        $this->authenticatedUser = factory(User::class)->create([
            'role' => 'owner',
        ]);

        Livewire::actingAs($this->authenticatedUser);
    }
}

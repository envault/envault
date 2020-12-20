<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_view_users()
    {
        Livewire::test('users.index')
            ->assertSee($this->authenticatedUser->full_name);
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

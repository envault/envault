<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_delete_user()
    {
        $userToDelete = User::factory()->create();

        Livewire::test('users.delete', ['user' => $userToDelete])
            ->call('destroy', $userToDelete->id)
            ->assertEmitted('user.deleted', $userToDelete->id);

        $this->assertSoftDeleted('users', [
            'id' => $userToDelete->id,
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

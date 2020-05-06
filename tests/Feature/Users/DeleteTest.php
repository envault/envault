<?php

namespace Tests\Feature\Users;

use App\User;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_delete_user()
    {
        $userToDelete = factory(User::class)->create();

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

        $this->authenticatedUser = factory(User::class)->create([
            'role' => 'owner',
        ]);

        Livewire::actingAs($this->authenticatedUser);
    }
}

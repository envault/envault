<?php

namespace Tests\Feature\Users;

use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class EditTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_update_user()
    {
        $userToUpdate = User::factory()->create();

        $newDetails = $userToUpdate;

        Livewire::test('users.edit', ['user' => $userToUpdate])
            ->set('email', $newDetails->email)
            ->set('firstName', $newDetails->first_name)
            ->set('lastName', $newDetails->last_name)
            ->set('role', 'admin')
            ->call('update')
            ->assertEmitted('user.updated', $userToUpdate->id);

        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'email' => $newDetails->email,
            'first_name' => $newDetails->first_name,
            'last_name' => $newDetails->last_name,
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function email_is_email()
    {
        $userToUpdate = User::factory()->create();

        Livewire::test('users.edit', ['user' => $userToUpdate])
            ->set('email', 'email')
            ->call('update')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function email_is_required()
    {
        $userToUpdate = User::factory()->create();

        Livewire::test('users.edit', ['user' => $userToUpdate])
            ->set('email', '')
            ->call('update')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function email_is_unique()
    {
        $userToUpdate = User::factory()->create();

        Livewire::test('users.edit', ['user' => $userToUpdate])
            ->set('email', $this->authenticatedUser->email)
            ->call('update')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    public function first_name_is_required()
    {
        $userToUpdate = User::factory()->create();

        Livewire::test('users.edit', ['user' => $userToUpdate])
            ->set('firstName', '')
            ->call('update')
            ->assertHasErrors(['firstName' => 'required']);
    }

    /** @test */
    public function last_name_is_required()
    {
        $userToUpdate = User::factory()->create();

        Livewire::test('users.edit', ['user' => $userToUpdate])
            ->set('lastName', '')
            ->call('update')
            ->assertHasErrors(['lastName' => 'required']);
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

<?php

namespace Tests\Feature;

use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class SetupTest extends TestCase
{
    /** @test */
    public function can_setup()
    {
        $userToCreate = User::factory()->make();

        Livewire::test('setup')
            ->set('email', $userToCreate->email)
            ->set('firstName', $userToCreate->first_name)
            ->set('lastName', $userToCreate->last_name)
            ->call('setup')
            ->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'email' => $userToCreate->email,
            'first_name' => $userToCreate->first_name,
            'last_name' => $userToCreate->last_name,
            'role' => 'owner',
        ]);

        $this->assertAuthenticatedAs(User::first());
    }

    /** @test */
    public function cannot_setup_when_users_present()
    {
        User::factory()->create();

        $this->assertGreaterThanOrEqual(1, User::count());

        Livewire::test('setup')
            ->call('setup')
            ->assertRedirect('/');
    }

    /** @test */
    public function email_is_email()
    {
        Livewire::test('setup')
            ->set('email', 'email')
            ->call('setup')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function email_is_required()
    {
        Livewire::test('setup')
            ->call('setup')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function first_name_is_required()
    {
        Livewire::test('setup')
            ->call('setup')
            ->assertHasErrors(['firstName' => 'required']);
    }

    /** @test */
    public function last_name_is_required()
    {
        Livewire::test('setup')
            ->call('setup')
            ->assertHasErrors(['lastName' => 'required']);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class AccountTest extends TestCase
{
    protected $authenticatedUser;

    /** @test */
    public function can_view_account_details()
    {
        Livewire::test('account')
            ->assertSet('email', $this->authenticatedUser->email)
            ->assertSet('firstName', $this->authenticatedUser->first_name)
            ->assertSet('lastName', $this->authenticatedUser->last_name);
    }

    /** @test */
    public function can_update_account_details()
    {
        $newDetails = User::factory()->make();

        Livewire::test('account')
            ->set('email', $newDetails->email)
            ->set('firstName', $newDetails->first_name)
            ->set('lastName', $newDetails->last_name)
            ->call('update')
            ->assertEmitted('account.updated');

        $this->assertDatabaseHas('users', [
            'id' => $this->authenticatedUser->id,
            'email' => $newDetails->email,
            'first_name' => $newDetails->first_name,
            'last_name' => $newDetails->last_name,
        ]);
    }

    /** @test */
    public function email_is_email()
    {
        Livewire::test('account')
            ->set('email', 'email')
            ->call('update')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function email_is_required()
    {
        Livewire::test('account')
            ->set('email', '')
            ->call('update')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function email_is_unique()
    {
        $existingUser = User::factory()->create();

        Livewire::test('account')
            ->set('email', $existingUser->email)
            ->call('update')
            ->assertHasErrors(['email' => 'unique']);
    }

    /** @test */
    public function first_name_is_required()
    {
        Livewire::test('account')
            ->set('firstName', '')
            ->call('update')
            ->assertHasErrors(['firstName' => 'required']);
    }

    /** @test */
    public function last_name_is_required()
    {
        Livewire::test('account')
            ->set('lastName', '')
            ->call('update')
            ->assertHasErrors(['lastName' => 'required']);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->authenticatedUser = User::factory()->create([
            'role' => 'owner',
        ]);

        Livewire::actingAs($this->authenticatedUser);
    }
}

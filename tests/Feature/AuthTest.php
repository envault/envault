<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /** @test */
    public function can_confirm_token_and_authenticate_user()
    {
        $user = factory(User::class)->create();

        Livewire::test('auth')
            ->set('token', Hash::make('token'))
            ->set('tokenAttempt', 'token')
            ->set('user', $user)
            ->call('confirm')
            ->assertEmitted('auth.confirmed');

        $this->assertEquals(user()->email, $user->email);
    }

    /** @test */
    public function can_request_auth()
    {
        $user = factory(User::class)->create();

        Livewire::test('auth')
            ->set('email', $user->email)
            ->call('request')
            ->assertSet('user.id', $user->id)
            ->assertEmitted('auth.request.sent')
            ->assertEmitted('auth.requested');
    }

    /** @test */
    public function can_send_auth_request()
    {
        $user = factory(User::class)->create();

        Livewire::test('auth')
            ->set('user', $user)
            ->call('sendRequest')
            ->assertNotSet('token', null)
            ->assertEmitted('auth.request.sent');
    }

    /** @test */
    public function email_is_email()
    {
        Livewire::test('auth')
            ->set('email', 'email')
            ->call('request')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function email_is_required()
    {
        Livewire::test('auth')
            ->call('request')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function email_exists()
    {
        Livewire::test('auth')
            ->set('email', $this->faker->email)
            ->call('request')
            ->assertHasErrors(['email' => 'exists']);
    }

    /** @test */
    public function token_attempt_is_required()
    {
        Livewire::test('auth')
            ->call('confirm')
            ->assertHasErrors(['tokenAttempt' => 'required']);
    }

    /** @test */
    public function token_attempt_is_valid()
    {
        Livewire::test('auth')
            ->set('tokenAttempt', 'token')
            ->call('confirm')
            ->assertHasErrors('tokenAttempt');
    }
}

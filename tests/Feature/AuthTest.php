<?php

namespace Tests\Feature;

use App\AuthRequest;
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

        $requestToValidate = $user->auth_requests()->create([
            'token' => Hash::make('token'),
        ]);

        Livewire::test('auth')
            ->set('request', $requestToValidate)
            ->set('token', 'token')
            ->set('user', $user)
            ->call('confirm')
            ->assertEmitted('auth.confirmed');

        $this->assertEquals(user()->id, $user->id);
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
            ->call('processRequest')
            ->assertNotSet('request', null)
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
    public function token_is_required()
    {
        Livewire::test('auth')
            ->call('confirm')
            ->assertHasErrors(['token' => 'required']);
    }

    /** @test */
    public function token_is_valid()
    {
        $user = factory(User::class)->create();

        $requestToValidate = $user->auth_requests()->create([
            'token' => Hash::make('token'),
        ]);

        Livewire::test('auth')
            ->set('request', $requestToValidate)
            ->set('token', 'incorrect-token')
            ->set('user', $user)
            ->call('confirm')
            ->assertHasErrors('token');
    }
}

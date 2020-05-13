<?php

namespace App\Http\Livewire;

use App\Notifications\AuthRequestedNotification;
use App\Rules\ValidAuthToken;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;

class Auth extends Component
{
    /**
     * @var string
     */
    public $email = '';

    /**
     * @var string
     */
    public $token = '';

    /**
     * @var string
     */
    public $tokenAttempt = '';

    /**
     * @var \App\User|null
     */
    public $user;

    /**
     * @return void
     */
    public function confirm()
    {
        $this->validate([
            'tokenAttempt' => ['required', new ValidAuthToken($this->token)],
        ]);

        auth()->login($this->user);

        $this->user->last_login_at = carbon();
        $this->user->save();

        $this->emit('auth.confirmed');

        event(new \App\Events\Users\SignedInEvent($this->user));

        redirect()->route('home');
    }

    /**
     * @return void
     */
    public function request()
    {
        $this->validate([
            'email' => ['required', 'email', 'exists:users'],
        ]);

        $this->user = User::where('email', $this->email)->firstOrFail();

        $this->sendRequest();

        $this->emit('auth.requested');
    }

    /**
     * @param bool $resend
     * @return void
     */
    public function sendRequest($resend = false)
    {
        $token = Str::random(16);

        $this->user->notify(new AuthRequestedNotification($token));

        $this->token = Hash::make($token);

        $this->emit('auth.request.sent');

        if ($resend) {
            $this->emit('auth.request.resent');
        }
    }

    /**
     * @return void
     */
    public function mount()
    {
        $this->email = request()->input('email') ?? null;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('auth');
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class Setup extends Component
{
    /**
     * @var string
     */
    public $email = '';

    /**
     * @var string
     */
    public $firstName = '';

    /**
     * @var string
     */
    public $lastName = '';

    /**
     * @var array
     */
    protected $rules = [
        'email' => ['required', 'email'],
        'firstName' => ['required'],
        'lastName' => ['required'],
    ];

    /**
     * @return void
     */
    public function setup()
    {
        if (User::count()) return redirect('/');

        $this->validate();

        $user = User::create([
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_login_at' => now(),
            'last_name' => $this->lastName,
            'role' => 'owner',
        ]);

        event(new \App\Events\Users\CreatedEvent($user));

        event(new \App\Events\Users\SignedInEvent($user));

        auth()->login($user);

        redirect('/');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('setup')->layout('layouts.basic');
    }
}

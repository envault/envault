<?php

namespace App\Http\Livewire\Users;

use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public function store()
    {
        $this->authorize('create', User::class);

        $this->validate([
            'email' => ['required', 'email', Rule::unique('users')->whereNull('deleted_at')],
            'firstName' => ['required'],
            'lastName' => ['required'],
        ]);

        $user = User::create([
            'email' => $this->email,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ]);

        $this->emit('user.created', $user->id);

        $user->log()->create([
            'action' => 'created',
            'description' => "{$user->full_name} ({$user->email}) was added as a user.",
        ]);

        $this->reset();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('users.create');
    }
}

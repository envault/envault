<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
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
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store()
    {
        $this->authorize('create', User::class);

        $this->validate([
            'email' => ['required', 'email', Rule::unique('users')->whereNull('deleted_at')],
            'firstName' => ['required'],
            'lastName' => ['required'],
        ]);

        $user = User::onlyTrashed()->updateOrCreate([
            'email' => $this->email,
        ], [
            'deleted_at' => null,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
        ]);

        $this->emit('user.created', $user->id);

        event(new \App\Events\Users\CreatedEvent($user));

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

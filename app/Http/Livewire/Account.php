<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Account extends Component
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
     * @var \App\User
     */
    public $user;

    /**
     * @return void
     */
    public function update()
    {
        $this->validate([
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user)->whereNull('deleted_at')],
            'firstName' => ['required'],
            'lastName' => ['required'],
        ]);

        $oldEmail = $this->user->email;
        $oldFullName = $this->user->full_name;

        $this->user->email = $this->email;
        $this->user->first_name = $this->firstName;
        $this->user->last_name = $this->lastName;

        $this->user->save();

        $this->emit('account.updated');

        if ($oldEmail != $this->user->email) {
            $this->user->log()->create([
                'action' => 'updated.email',
                'description' => "The email for {$this->user->full_name} was updated from {$oldEmail} to {$this->user->email}.",
            ]);
        }

        if ($oldFullName != $this->user->full_name) {
            $this->user->log()->create([
                'action' => 'updated.full-name',
                'description' => "The user {$oldFullName} was renamed to {$this->user->full_name}.",
            ]);
        }
    }

    /**
     * @param string $field
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    public function updated($field)
    {
        $this->validateOnly($field, [
            'email' => ['required', Rule::unique('users')->ignore($this->user)->whereNull('deleted_at')],
            'firstName' => ['required'],
            'lastName' => ['required'],
        ]);
    }

    /**
     * @return void
     */
    public function mount()
    {
        $this->email = user()->email;
        $this->firstName = user()->first_name;
        $this->lastName = user()->last_name;

        $this->user = user();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        View::share([
            'title' => 'My Account',
        ]);

        return view('account');
    }
}

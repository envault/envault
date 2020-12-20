<?php

namespace App\Http\Livewire;

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
     * @var \App\Models\User
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
            event(new \App\Events\Users\EmailUpdatedEvent($this->user, $oldEmail, $this->user->email));
        }

        if ($oldFullName != $this->user->full_name) {
            event(new \App\Events\Users\NameUpdatedEvent($this->user, $oldFullName, $this->user->full_name));
        }
    }

    /**
     * @param string $field
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
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
        $this->email = auth()->user()->email;
        $this->firstName = auth()->user()->first_name;
        $this->lastName = auth()->user()->last_name;
        $this->user = auth()->user();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('account');
    }
}

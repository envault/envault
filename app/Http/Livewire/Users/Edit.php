<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
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
     * @var string
     */
    public $role = '';

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update()
    {
        $this->authorize('update', $this->user);

        $this->validate([
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user)->whereNull('deleted_at')],
            'firstName' => ['required'],
            'lastName' => ['required'],
        ]);

        $oldEmail = $this->user->email;
        $oldFullName = $this->user->full_name;
        $oldRole = $this->user->role;

        $this->user->email = $this->email;
        $this->user->first_name = $this->firstName;
        $this->user->last_name = $this->lastName;

        if (auth()->user()->can('updateRole', $this->user)) {
            $this->user->role = $this->role ?: null;
        }

        $this->user->save();

        $this->emit('user.updated', $this->user->id);

        if ($oldEmail != $this->user->email) {
            event(new \App\Events\Users\EmailUpdatedEvent($this->user, $oldEmail, $this->user->email));
        }

        if ($oldFullName != $this->user->full_name) {
            event(new \App\Events\Users\NameUpdatedEvent($this->user, $oldFullName, $this->user->full_name));
        }

        if ($oldRole != $this->user->role) {
            event(new \App\Events\Users\RoleUpdatedEvent($this->user, $oldRole, $this->user->role));
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
     * @param \App\Models\User $user
     * @return void
     */
    public function mount(User $user)
    {
        $this->email = $user->email;
        $this->firstName = $user->first_name;
        $this->lastName = $user->last_name;
        $this->role = $user->role;
        $this->user = $user;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('users.edit');
    }
}

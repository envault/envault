<?php

namespace App\Http\Livewire\Users;

use App\User;
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
     * @var \App\User
     */
    public $user;

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
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

        if (user()->can('updateRole', $this->user)) {
            $this->user->role = $this->role ?: null;
        }

        $this->user->save();

        $this->emit('user.updated', $this->user->id);

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

        if ($oldRole != $this->user->role) {
            $roleName = $this->user->role ?: 'user';

            $this->user->log()->create([
                'action' => 'updated.role',
                'description' => "The user {$this->user->full_name} ({$this->user->email}) was given the role of {$roleName}.",
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
     * @param \App\User $user
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

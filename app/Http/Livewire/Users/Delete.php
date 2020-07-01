<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\Models\User
     */
    public $user;

    /**
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy()
    {
        $this->authorize('delete', $this->user);

        $this->user->delete();

        $this->emit('user.deleted', $this->user->id);

        event(new \App\Events\Users\DeletedEvent($this->user));
    }

    /**
     * @param \App\Models\User $user
     * @return void
     */
    public function mount(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('users.delete');
    }
}

<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Index extends Component
{
    use AuthorizesRequests;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $users;

    /**
     * @var array
     */
    protected $listeners = [
        'user.created' => '$refresh',
        'user.deleted' => '$refresh',
        'user.updated' => '$refresh',
    ];

    /**
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount()
    {
        $this->authorize('viewAny', User::class);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $this->users = User::orderBy('first_name')->get();

        // @todo investigate why this causes CorruptComponentPayloadException on open
        // $this->users = User::all()->sortBy('last_name')->sortBy('first_name');

        return view('users.index');
    }
}

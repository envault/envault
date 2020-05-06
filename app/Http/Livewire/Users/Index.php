<?php

namespace App\Http\Livewire\Users;

use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
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

        View::share([
            'title' => 'Users',
        ]);

        return view('users.index');
    }
}

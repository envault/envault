<?php

namespace App\Http\Livewire\Apps\Edit;

use App\App;
use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Collaborators extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\App
     */
    public $app;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $globalAdmins;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $addableUsers;

    /**
     * @var string
     */
    public $userToAddId;

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public function add()
    {
        $this->authorize('update', $this->app);

        $this->validate([
            'userToAddId' => ['required', 'exists:users,id'],
        ]);

        $userToAdd = User::findOrFail($this->userToAddId);

        $this->app->collaborators()->attach($this->userToAddId);

        $this->emit('app.collaborator.added', $this->userToAddId, $this->app->id);

        $this->app->log()->create([
            'action' => 'collaborator.added',
            'description' => "{$userToAdd->full_name} ({$userToAdd->email}) was added as a collaborator to the {$this->app->name} app.",
        ]);

        $this->mount($this->app->refresh());
    }

    /**
     * @param \App\App $app
     * @return void
     */
    public function mount(App $app)
    {
        $this->app = $app;

        $this->globalAdmins = User::whereIn('role', ['admin', 'owner'])->get();

        $this->addableUsers = User::whereNotIn('role', ['admin', 'owner'])->orWhereNull('role')->get()->filter(function (User $user): bool {
            return ! $user->isAppCollaborator($this->app);
        });

        if (count($this->addableUsers)) {
            $this->userToAddId = $this->addableUsers->first()->id;
        }
    }

    /**
     * @param int $id
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public function remove($id)
    {
        $this->authorize('update', $this->app);

        $userToRemove = User::findOrFail($id);

        $this->app->collaborators()->detach($id);

        $this->emit('app.collaborator.removed', $id, $this->app->id);

        $this->app->log()->create([
            'action' => 'collaborator.removed',
            'description' => "{$userToRemove->full_name} ({$userToRemove->email}) was removed as a collaborator from the {$this->app->name} app.",
        ]);

        $this->mount($this->app->refresh());
    }

    /**
     * @param int $id
     * @param string|null $role
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public function updateRole($id, $role)
    {
        $this->authorize('update', $this->app);

        $userToUpdate = User::findOrFail($id);

        $this->app->collaborators()->updateExistingPivot($id, [
            'role' => $role,
        ]);

        $this->emit('app.collaborator.updated', $id, $this->app->id);

        $roleName = $role ?: 'user';

        $this->app->log()->create([
            'action' => 'collaborator.updated.role',
            'description' => "The user {$userToUpdate->full_name} ({$userToUpdate->email}) was given the role of {$roleName} for the {$this->app->name} app.",
        ]);

        $this->mount($this->app->refresh());
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('apps.edit.collaborators');
    }
}

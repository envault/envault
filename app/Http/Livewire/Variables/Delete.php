<?php

namespace App\Http\Livewire\Variables;

use App\Notifications\VariableDeletedNotification;
use App\Variable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\Variable
     */
    public $variable;

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public function destroy()
    {
        $this->authorize('delete', $this->variable);

        $this->variable->delete();

        $this->emit('variable.deleted', $this->variable->id);

        $this->variable->app->log()->create([
            'action' => 'variable.deleted',
            'description' => "The variable {$this->variable->key} was removed from the {$this->variable->app->name} app.",
        ]);

        if ($this->variable->app->slack_notifications_set_up) {
            $this->variable->app->notify(new VariableDeletedNotification($this->variable));
        }
    }

    /**
     * @param \App\Variable $variable
     * @return void
     */
    public function mount(Variable $variable)
    {
        $this->variable = $variable;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('variables.delete');
    }
}

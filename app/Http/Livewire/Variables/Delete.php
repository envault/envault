<?php

namespace App\Http\Livewire\Variables;

use App\Models\Variable;
use App\Notifications\VariableDeletedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\Models\Variable
     */
    public $variable;

    /**
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy()
    {
        $this->authorize('delete', $this->variable);

        $this->variable->delete();

        $this->emit('variable.deleted', $this->variable->id);

        event(new \App\Events\Variables\DeletedEvent($this->variable->app, $this->variable));
    }

    /**
     * @param \App\Models\Variable $variable
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

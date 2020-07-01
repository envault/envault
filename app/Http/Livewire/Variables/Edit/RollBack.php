<?php

namespace App\Http\Livewire\Variables\Edit;

use App\Models\Variable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class RollBack extends Component
{
    use AuthorizesRequests;

    /**
     * @var string|null
     */
    public $selectedVersionCreatedAt;

    /**
     * @var int|null
     */
    public $selectedVersionId;

    /**
     * @var string|null
     */
    public $selectedVersionValue;

    /**
     * @var \App\Models\Variable
     */
    public $variable;

    /**
     * @param int $id
     * @param string $value
     * @param string $createdAt
     */
    public function selectVersion($id, $value, $createdAt)
    {
        if ($this->selectedVersionId != $id) {
            $this->selectedVersionCreatedAt = $createdAt;
            $this->selectedVersionId = $id;
            $this->selectedVersionValue = $value;

            $this->emit('variable.version.selected', $id);
        } else {
            $this->selectedVersionCreatedAt = null;
            $this->selectedVersionId = null;
            $this->selectedVersionValue = null;

            $this->emit('variable.version.deselected');
        }
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
        return view('variables.edit.roll-back');
    }
}

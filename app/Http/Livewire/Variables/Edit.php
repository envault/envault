<?php

namespace App\Http\Livewire\Variables;

use App\Notifications\VariableUpdatedNotification;
use App\Variable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;

    /**
     * @var string
     */
    public $key = '';

    /**
     * @var bool
     */
    public $openRollBack = false;

    /**
     * @var string
     */
    public $value = '';

    /**
     * @var \App\Variable
     */
    public $variable;

    /**
     * @var array
     */
    protected $listeners = [
        'variableRolledBack' => 'restoreVersion',
    ];

    /**
     * @param string $value
     * @return void
     */
    public function restoreVersion($value)
    {
        $this->value = $value;

        $this->openRollBack = false;

        $this->emit('variable.version.restored');
    }

    /**
     * @return void
     */
    public function toggleOpenRollBack()
    {
        $this->openRollBack = ! $this->openRollBack;

        $this->emit($this->openRollBack ? 'variable.roll-back.opened' : 'variable.roll-back.closed');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public function update()
    {
        $this->authorize('update', $this->variable);

        $this->validate([
            'key' => ['required', 'alpha_dash', Rule::unique('variables')->ignore($this->variable)->where(function ($query) {
                return $query->where('app_id', $this->variable->app->id);
            })->whereNull('deleted_at')],
        ]);

        $oldValue = $this->variable->latest_version->value ?? null;

        if ($oldValue != $this->value) {
            $this->variable->versions()->create([
                'value' => $this->value,
            ]);

            $this->variable->app->log()->create([
                'action' => 'variable.updated.value',
                'description' => "The value of the {$this->variable->key} variable was updated for the {$this->variable->app->name} app.",
            ]);
        }

        $oldKey = $this->variable->key;

        $this->variable->key = $this->key;

        $this->variable->save();

        $this->emit('variable.updated', $this->variable->id);

        if ($oldKey != $this->variable->key) {
            $this->variable->app->log()->create([
                'action' => 'variable.updated.key',
                'description' => "The {$oldKey} variable was renamed to {$this->variable->key} for the {$this->variable->app->name} app.",
            ]);
        }

        if ($this->variable->app->slack_notifications_set_up && ($oldValue != $this->value || $oldKey != $this->variable->key)) {
            $this->variable->app->notify(new VariableUpdatedNotification($this->variable));
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
            'key' => ['alpha_dash', Rule::unique('variables')->ignore($this->variable)->where(function ($query) {
                return $query->where('app_id', $this->variable->app->id);
            })->whereNull('deleted_at')],
        ]);
    }

    /**
     * @param \App\Variable $variable
     * @return void
     */
    public function mount(Variable $variable)
    {
        $this->key = $variable->key;

        $this->value = $variable->latest_version->value ?? '';

        $this->variable = $variable;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('variables.edit');
    }
}

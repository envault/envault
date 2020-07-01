<?php

namespace App\Http\Livewire\Variables;

use App\Models\Variable;
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
     * @var \App\Models\Variable
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
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
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

            event(new \App\Events\Variables\ValueUpdatedEvent($this->variable->app, $this->variable));
        }

        $oldKey = $this->variable->key;

        $this->variable->key = $this->key;

        $this->variable->save();

        $this->emit('variable.updated', $this->variable->id);

        if ($oldKey != $this->variable->key) {
            event(new \App\Events\Variables\KeyUpdatedEvent($this->variable->app, $this->variable, $oldKey, $this->variable->key));
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
            'key' => ['alpha_dash', Rule::unique('variables')->ignore($this->variable)->where(function ($query) {
                return $query->where('app_id', $this->variable->app->id);
            })->whereNull('deleted_at')],
        ]);
    }

    /**
     * @param \App\Models\Variable $variable
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

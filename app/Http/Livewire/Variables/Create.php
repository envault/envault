<?php

namespace App\Http\Livewire\Variables;

use App\App;
use App\Notifications\VariableCreatedNotification;
use App\Notifications\VariablesCreatedNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\App
     */
    public $app;

    /**
     * @var string
     */
    public $key = '';

    /**
     * @var string
     */
    public $value = '';

    /**
     * @var string
     */
    public $variables = '';

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public function import()
    {
        $this->authorize('createVariable', $this->app);

        $lines = collect(explode(PHP_EOL, $this->variables));

        $count = 0;

        $lines->each(function ($line) use (&$count) {
            if (Str::contains($line, '=')) {
                $variable = explode('=', $line, 2);

                $key = $variable[0];

                $value = $variable[1];

                // Trim " from start and end of value if it's there
                if (Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
                    $value = substr($value, 1, -1);
                }

                if ($key && (is_string($key) || is_numeric($key)) && preg_match('/^[\pL\pM\pN_-]+$/u', $key) > 0) {
                    $validator = Validator::make([
                        'key' => $key,
                    ], [
                        'key' => ['required', 'alpha_dash', Rule::unique('variables')->where(function ($query) {
                            return $query->where('app_id', $this->app->id);
                        })->whereNull('deleted_at')],
                    ]);

                    if (! $validator->fails()) {
                        $variable = $this->app->variables()->create([
                            'key' => $key,
                        ]);

                        $variable->versions()->create([
                            'value' => $value,
                        ]);

                        $this->app->log()->create([
                            'action' => 'variable.created',
                            'description' => "The variable {$variable->key} was added to the {$this->app->name} app.",
                        ]);

                        $count += 1;
                    }
                }
            }
        });

        if ($count) {
            $this->emit('variables.created', $count);

            if ($this->app->slack_notifications_set_up) {
                $this->app->notify(new VariablesCreatedNotification());
            }
        }

        $this->variables = '';
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public function store()
    {
        $this->authorize('createVariable', $this->app);

        $variable = $this->app->variables()->create($this->validate([
            'key' => ['required', 'alpha_dash', Rule::unique('variables')->where(function ($query) {
                return $query->where('app_id', $this->app->id);
            })->whereNull('deleted_at')],
        ]));

        $variable->versions()->create([
            'value' => $this->value,
        ]);

        $this->emit('variable.created', $variable->id);

        $this->app->log()->create([
            'action' => 'variable.created',
            'description' => "The variable {$variable->key} was added to the {$this->app->name} app.",
        ]);

        if ($this->app->slack_notifications_set_up) {
            $this->app->notify(new VariableCreatedNotification($variable));
        }

        $this->reset('key', 'value');
    }

    /**
     * @param string $field
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    public function updated($field)
    {
        $this->validateOnly($field, [
            'key' => ['alpha_dash', Rule::unique('variables')->where(function ($query) {
                return $query->where('app_id', $this->app->id);
            })->whereNull('deleted_at')],
        ]);
    }

    /**
     * @param \App\App $app
     * @return void
     */
    public function mount(App $app)
    {
        $this->app = $app;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('variables.create');
    }
}

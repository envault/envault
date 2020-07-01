<?php

namespace App\Http\Livewire\Variables;

use App\Models\App;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\Models\App
     */
    public $app;

    /**
     * @var string
     */
    public $key = '';

    /**
     * @var string
     */
    public $import = '';

    /**
     * @var string
     */
    public $value = '';

    /**
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function import()
    {
        $this->authorize('createVariable', $this->app);

        $totalImported = 0;

        collect(explode(PHP_EOL, $this->import))->filter(function ($line) {
            return Str::contains($line, '=');
        })->each(function ($line) use (&$totalImported) {
            $lineComponents = explode('=', $line, 2);
            $key = $lineComponents[0] ?? null;
            $value = $lineComponents[1] ?? null;

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

                $totalImported += 1;
            }
        });

        if ($totalImported) {
            $this->emit('variables.imported', $totalImported);

            event(new \App\Events\Variables\ImportedEvent($this->app, $totalImported));
        }

        $this->reset('import');
    }

    /**
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
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

        event(new \App\Events\Variables\CreatedEvent($this->app, $variable));

        $this->reset('key', 'value');
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
            'key' => ['alpha_dash', Rule::unique('variables')->where(function ($query) {
                return $query->where('app_id', $this->app->id);
            })->whereNull('deleted_at')],
        ]);
    }

    /**
     * @param \App\Models\App $app
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

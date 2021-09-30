<?php

namespace App\Http\Livewire\Variables;

use App\Models\App;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Create extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    /**
     * @var \App\Models\App
     */
    public $app;

    /**
     * @var string
     */
    public $label = '';

    /**
     * @var string
     */
    public $key = '';

    /**
     * @var string
     */
    public $import = '';

    /**
     * @var TemporaryUploadedFile
     */
    public $importFile;

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

        collect(preg_split('/\r\n|\n|\r/', $this->import))->filter(function ($line) {
            return Str::contains($line, '=');
        })->each(function ($line) use (&$totalImported) {
            $lineComponents = explode('=', $line, 2);
            $key = trim($lineComponents[0] ?? '');
            $value = trim($lineComponents[1] ?? '');

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
            'label' => 'required'
        ]));

        $variable->versions()->create([
            'value' => $this->value,
        ]);

        $this->emit('variable.created', $variable->id);

        event(new \App\Events\Variables\CreatedEvent($this->app, $variable));

        $this->reset('label', 'key', 'value');
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
     * @param TemporaryUploadedFile $file
     * @return void
     */
    public function updatedImportFile($file)
    {
        $this->validateOnly('importFile', [
            'importFile' => ['file', 'mimetypes:text/plain'],
        ]);

        $this->import = $file->get();

        $file->delete();

        $this->importFile = null;
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

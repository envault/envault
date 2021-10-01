<?php

namespace App\Http\Livewire\Variables;

use App\Models\App;
use Livewire\Component;
use App\Models\Variable;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Index extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\Models\App
     */
    public $app;

    /**
     * @var \Illuminate\Database\Eloquent\Collection
     */
    public $variables;

    /**
     * @var array
     */
    protected $listeners = [
        'variable.created' => '$refresh',
        'variable.deleted' => '$refresh',
        'variable.updated' => '$refresh',
        'variables.imported' => '$refresh',
    ];

    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export()
    {
        $fileName = (string) Str::of($this->app->name)
            ->slug('_')
            ->finish('.env');

        $contents = $this->app
            ->variables()
            ->orderBy('order')
            ->orderBy('id')
            ->get()
            ->map(function (Variable $variable) {
                return (string) Str::of($variable->key)
                    ->append('=')
                    ->append($variable->latest_version->value);
            })
            ->implode(PHP_EOL);

        return response()->streamDownload(function () use ($contents) {
            echo $contents;
        }, $fileName);
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
     * @return void
     */
    public function updateVariableOrder($variables)
    {
        foreach($variables as $variable) {
            $this->app->variables()->find($variable['value'])->update(['order' => $variable['order']]);
        }

        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Update order successfully!']);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $this->variables = $this->app->variables()->orderBy('order')->orderBy('id')->get();

        return view('variables.index');
    }
}

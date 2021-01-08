<?php

namespace App\Http\Livewire\Variables;

use App\Models\App;
use Livewire\Component;
use App\Models\Variable;
use Illuminate\Support\Arr;
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

    public function exportToEnvFile()
    {
        $envFileName = Str::of($this->app->name)
                        ->replace(' ','_')
                        ->finish('.env')
                        ->__toString();

        $keyValuePairs = $this->app
                ->variables()
                ->orderBy('key')
                ->get()
                ->map(function(Variable $variable){

                    $variableArray = $variable->toArray();
                    
                    return Str::of(Arr::get($variableArray,'key'))
                            ->append('=')
                            ->append(Arr::get($variableArray,'latest_version.value'))
                            ->__toString();
                })
                ->implode(PHP_EOL);

        return response()->streamDownload(function () use ($keyValuePairs){
            echo $keyValuePairs;
        }, $envFileName);
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
        $this->variables = $this->app->variables()->orderBy('key')->get();

        return view('variables.index');
    }
}

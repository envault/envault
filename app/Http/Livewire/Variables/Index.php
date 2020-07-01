<?php

namespace App\Http\Livewire\Variables;

use App\Models\App;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

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

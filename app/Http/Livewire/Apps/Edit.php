<?php

namespace App\Http\Livewire\Apps;

use App\Models\App;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\Models\App
     */
    public $app;

    /**
     * @var array
     */
    protected $listeners = [
        'app.updated' => 'update',
    ];

    /**
     * @return void
     */
    public function update()
    {
        $this->app->refresh();
    }

    /**
     * @param \App\Models\App $app
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(App $app)
    {
        $this->authorize('update', $app);

        $this->app = $app;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('apps.edit');
    }
}

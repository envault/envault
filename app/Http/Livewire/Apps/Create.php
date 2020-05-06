<?php

namespace App\Http\Livewire\Apps;

use App\App;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

    /**
     * @var string
     */
    public $name = '';

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public function store()
    {
        $this->authorize('create', App::class);

        $app = App::create($this->validate([
            'name' => ['required'],
        ]));

        $this->emit('app.created', $app->id);

        $app->log()->create([
            'action' => 'created',
            'description' => "The {$app->name} app was created.",
        ]);

        redirect()->route('apps.show', [
            'app' => $app->id,
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('apps.create');
    }
}

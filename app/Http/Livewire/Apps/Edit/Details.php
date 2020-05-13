<?php

namespace App\Http\Livewire\Apps\Edit;

use App\App;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Details extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\App
     */
    public $app;

    /**
     * @var string
     */
    public $name = '';

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public function destroy()
    {
        $this->authorize('delete', $this->app);

        $this->app->delete();

        $this->emit('app.deleted', $this->app->id);

        event(new \App\Events\Apps\DeletedEvent($this->app));

        redirect()->route('apps.index');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @return void
     */
    public function update()
    {
        $this->authorize('update', $this->app);

        $this->validate([
            'name' => ['required'],
        ]);

        $oldName = $this->app->name;

        $this->app->name = $this->name;

        $this->app->save();

        $this->emit('app.updated', $this->app->id);

        if ($oldName != $this->app->name) {
            event(new \App\Events\Apps\NameUpdatedEvent($this->app, $oldName, $this->app->name));
        }

        $this->mount($this->app->refresh());
    }

    /**
     * @param \App\App $app
     * @return void
     */
    public function mount(App $app)
    {
        $this->app = $app;
        $this->name = $app->name;
    }

    /**
     * @param string $field
     * @throws \Illuminate\Validation\ValidationException
     * @return void
     */
    public function updated($field)
    {
        $this->validateOnly($field, [
            'name' => ['required'],
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('apps.edit.details');
    }
}

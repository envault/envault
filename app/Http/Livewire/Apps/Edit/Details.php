<?php

namespace App\Http\Livewire\Apps\Edit;

use App\Models\App;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Details extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\Models\App
     */
    public $app;

    /**
     * @var string
     */
    public $name = '';

    /**
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @param \App\Models\App $app
     * @return void
     */
    public function mount(App $app)
    {
        $this->app = $app;
        $this->name = $app->name;
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

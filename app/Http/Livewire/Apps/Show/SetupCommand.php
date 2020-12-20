<?php

namespace App\Http\Livewire\Apps\Show;

use App\Models\App;
use App\Models\AppSetupToken;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Component;

class SetupCommand extends Component
{
    use AuthorizesRequests;

    /**
     * @var \App\Models\App
     */
    public $app;

    /**
     * @var string
     */
    public $token = '';

    /**
     * @var array
     */
    protected $listeners = [
        'app.setup-command.generate' => 'generate',
    ];

    /**
     * @param \App\Models\App $app
     * @return void
     */
    public function mount(App $app)
    {
        $this->app = $app;

        $this->generate();
    }

    /**
     * @return void
     */
    public function generate()
    {
        $this->token = Str::random(16);

        if (count(AppSetupToken::where('token', $this->token)->get())) {
            $this->generate();

            return;
        }

        $this->app->setup_tokens()->create([
            'token' => $this->token,
            'user_id' => auth()->user()->id,
        ]);

        $this->emit('app.setup-command.generated', $this->app->id);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('apps.show.setup-command');
    }
}

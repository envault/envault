<?php

namespace App\Http\Livewire\Apps;

use App\Models\App;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    /**
     * @var string
     */
    public $search = '';

    /**
     * @return string
     */
    public function paginationView()
    {
        return 'apps.index.pagination';
    }

    /**
     * @param string $field
     * @return void
     */
    public function updated($field)
    {
        // Reset pagination page on search
        if ($field == 'search') {
            $this->gotoPage(1);
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        if (auth()->user()->can('viewAll', App::class)) {
            $apps = App::query();
        } else {
            $apps = auth()->user()->app_collaborations();
        }

        $apps = $apps->where('name', 'like', '%'.$this->search.'%');

        return view('apps.index', [
            'apps' => $apps->orderBy('name')->paginate(10),
        ]);
    }
}

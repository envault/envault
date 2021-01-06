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
     * @return void
     */
    public function updatedSearch()
    {
        $this->resetPage();
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

        $apps = $apps->when($this->search, function ($query, $search) {
            return $query->where('name', 'like', '%'.$search.'%');
        });

        return view('apps.index', [
            'apps' => $apps->orderBy('name')->paginate(10),
        ]);
    }
}

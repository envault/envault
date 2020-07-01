<?php

namespace App\Http\Livewire;

use App\Models\LogEntry;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class Log extends Component
{
    use AuthorizesRequests;
    use WithPagination;

    /**
     * @var string|null
     */
    public $action = null;

    /**
     * @var int|null
     */
    public $appId = null;

    /**
     * @var int|null
     */
    public $userId = null;

    /**
     * @return string
     */
    public function paginationView()
    {
        return 'log.pagination';
    }

    /**
     * @param string $field
     */
    public function updated($field)
    {
        // Reset pagination page on filter
        if ($field == 'action' || $field == 'appId' || $field == 'userId') {
            $this->gotoPage(1);
        }

        // Reset app filter when an appless action is selected
        if (Str::before($this->action, '.') == 'user') {
            $this->appId = null;
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $entries = LogEntry::whereNotNull('description');

        if (Str::contains($this->action, '.')) {
            $entries = $entries->where([['action', Str::after($this->action, '.')], ['loggable_type', Str::before($this->action, '.')]]);
        }

        if ($this->appId && Str::before($this->action, '.') != 'user') {
            $entries = $entries->where([['loggable_id', $this->appId], ['loggable_type', 'app']]);
        }

        if ($this->userId) {
            $entries = $entries->where('user_id', $this->userId);
        }

        return view('log', [
            'entries' => $entries->orderBy('created_at', 'desc')->paginate(20),
        ]);
    }
}

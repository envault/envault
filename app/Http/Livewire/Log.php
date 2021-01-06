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
     * Executes when action is updated
     * 
     * @return void
     **/
    public function updatedAction()
    {
        $this->resetPage();
    }

    /**
     * Executes when appId is updated
     * 
     * @return void
     **/
    public function updatedAppId()
    {
        $this->resetPage();
    }

    /**
     * Executes when userId is updated
     * 
     * @return void
     **/
    public function updatedUserId()
    {
        $this->resetPage();
    }

    /**
     * @param string $field
     */
    public function updated($field)
    {
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
        $entries = LogEntry::query()
                        ->whereNotNull('description')
                        ->when(Str::contains($this->action, '.'),function($query){
                            return $query->where([['action', Str::after($this->action, '.')], ['loggable_type', Str::before($this->action, '.')]]);
                        })
                        ->when($this->appId && Str::before($this->action, '.') != 'user',function($query){
                            return $query->where([['loggable_id', $this->appId], ['loggable_type', 'app']]);
                        })->when($this->userId,function($query,$userId){
                            return $query->where('user_id', $userId);
                        });
                        
        return view('log', [
            'entries' => $entries->orderBy('created_at', 'desc')->paginate(20),
        ]);
    }
}

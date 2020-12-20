<?php

namespace App\Console\Commands;

use App\Models\AuthRequest;
use Illuminate\Console\Command;

class FlushAuthRequestsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth-requests:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush auth requests';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        AuthRequest::where('created_at', '<=', now()->subDay())->delete();

        $this->info('Auth requests flushed successfully.');
    }
}

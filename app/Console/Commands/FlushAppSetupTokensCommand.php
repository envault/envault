<?php

namespace App\Console\Commands;

use App\Models\AppSetupToken;
use Illuminate\Console\Command;

class FlushAppSetupTokensCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app-setup-tokens:flush';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush app setup tokens';

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
        AppSetupToken::where('created_at', '<=', now()->subMinutes(10))->delete();

        $this->info('App setup tokens flushed successfully.');
    }
}

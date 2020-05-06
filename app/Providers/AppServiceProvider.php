<?php

namespace App\Providers;

use App\App;
use App\LogEntry;
use App\Observers\AppObserver;
use App\Observers\LogEntryObserver;
use App\Observers\UserObserver;
use App\Observers\VariableObserver;
use App\User;
use App\Variable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'app' => App::class,
            'user' => User::class,
            'variable' => Variable::class,
        ]);

        App::observe(AppObserver::class);
        LogEntry::observe(LogEntryObserver::class);
        User::observe(UserObserver::class);
        Variable::observe(VariableObserver::class);
    }
}

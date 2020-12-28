<?php

namespace App\Providers;

use App\Models\App;
use App\Models\LogEntry;
use App\Models\User;
use App\Models\Variable;
use App\Observers\AppObserver;
use App\Observers\LogEntryObserver;
use App\Observers\UserObserver;
use App\Observers\VariableObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
        Schema::defaultStringLength(191);

        Relation::morphMap([
            'app' => App::class,
            'user' => User::class,
            'variable' => Variable::class,
        ]);

        App::observe(AppObserver::class);
        LogEntry::observe(LogEntryObserver::class);
        User::observe(UserObserver::class);
        Variable::observe(VariableObserver::class);

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

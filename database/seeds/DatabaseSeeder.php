<?php

use App\App;
use App\User;
use App\Variable;
use App\VariableVersion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create();

        factory(App::class, 50)->create()->each(function (App $app) {
            factory(Variable::class, 10)->create([
                'app_id' => $app->id,
            ])->each(function (Variable $variable) {
                factory(VariableVersion::class)->create([
                    'variable_id' => $variable->id,
                ]);
            });
        });
    }
}

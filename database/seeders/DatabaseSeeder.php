<?php

namespace Database\Seeders;

use App\Models\App;
use App\Models\User;
use App\Models\Variable;
use App\Models\VariableVersion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create();

        App::factory()->count(50)->has(
            Variable::factory()->count(10)->has(
                VariableVersion::factory(),
            'versions'),
        )->create();
    }
}

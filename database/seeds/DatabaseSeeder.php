<?php

use App\App;
use App\User;
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

        $user = User::first();
        $user->email = 'example@user.com';
        $user->role = 'owner';
        $user->save();

        factory(App::class, 50)->create();
    }
}

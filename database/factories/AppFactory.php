<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\App;
use Faker\Generator as Faker;

$factory->define(App::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});

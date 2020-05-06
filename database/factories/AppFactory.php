<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\App;
use Faker\Generator as Faker;

$factory->define(App::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});

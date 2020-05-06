<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Variable;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Variable::class, function (Faker $faker) {
    return [
        'key' => strtoupper(Str::random(16)),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\VariableVersion;
use Faker\Generator as Faker;

$factory->define(VariableVersion::class, function (Faker $faker) {
    return [
        'value' => $faker->word,
    ];
});

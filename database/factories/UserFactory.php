<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(\App\Models\User::class, function (Faker $faker) {
    return [
        'src_name' => $faker->userName,
        'src_id' => $faker->numberBetween(0, 100000),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(\App\Models\Vote::class, function (Faker $faker) {
    return [
        'v_timing_method_a' => $faker->randomElement(['Yes', 'No', 'No Vote']),
        'v_timing_method_b' => $faker->randomElement(['Yes', 'No', 'No Vote']),
        'v_timing_method_c' => $faker->randomElement(['Yes', 'No', 'No Vote']),
        'v_timing_method_d' => $faker->randomElement(['Yes', 'No', 'No Vote']),
        'v_hide_timings' => $faker->randomElement(['Yes', 'No', 'No Vote']),
        'state' => $faker->randomElement(['Pending', 'Verified', 'Rejected', 'Auto-Verified'])
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;


$factory->define(\App\Models\User::class, function (Faker $faker) {
    $uname = $faker->unique()->userName;
    return [
        'src_name' => $uname,
        'src_id' => $uname
    ];
});

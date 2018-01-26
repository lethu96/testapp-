<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\MemberProject::class, function (Faker $faker) {
    return [
        'meber_id' =>$faker->randomDigit,
        'project_id' => $faker->randomDigit,
        'role' => $faker->name,
    ];
});

<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Member::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'phone_number'=>$faker->randomDigit,
        'information'=>$faker->name,
        'birthday'=>$faker->dateTimeBetween('-7300 days', '+1 days'),
        'position_id'=>$faker->randomDigit,
        'gender'=>'male',
        'avatar'=> str_random(30)
    ];
});

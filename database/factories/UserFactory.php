<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'name'=>'halo',
        'information'=>'halo',
        'deadline'=>'2018-02-08',
        'type'=>'lab',
        'status'=>'planned',
    ];
});

$factory->define(App\MemberProject::class, function (Faker $faker) {
    return [
        'member_id' =>1,
        'project_id' => 1,
        'role' => $faker->name,
    ];
});

$factory->define(App\Member::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'phone_number'=>$faker->randomDigit,
        'information'=>$faker->name,
        'birthday'=>$faker->dateTimeBetween('-7300 days', '+1 days'),
        'position_id'=>1,
        'gender'=>'male',
        'avatar'=> str_random(30)
    ];
});
$factory->define(App\Position::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'description'=>str_random(30)
    ];
});

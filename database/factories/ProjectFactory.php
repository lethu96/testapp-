<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Project::class, function (Faker $faker) {
    return [
        'name'=>'halo',
        'information'=>'halo',
        'deadline'=>'2018-02-08',
        'type'=>'lab',
        'status'=>'planned',
    ];
});

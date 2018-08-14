<?php

use Faker\Generator as Faker;

$factory->define(App\Projects::class, function (Faker $faker) {
    return [

        'name' => $faker->company,
        'description' => $faker->address,
    ];
});
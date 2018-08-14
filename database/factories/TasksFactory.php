<?php

use Faker\Generator as Faker;

$factory->define(App\Tasks::class, function (Faker $faker) {
    $projArr=App\Projects::all()->pluck('id')->toArray();
    return [

        'name' => $faker->word,
        'description' => $faker->sentence,
        'project_id'=>$faker->randomElement($projArr),
    ];
});

<?php

use Faker\Generator as Faker;


        $factory->define(App\Details::class, function (Faker $faker) {
            return [

                'address' => $faker->address,
                'country' => $faker->country,
            ];
        });



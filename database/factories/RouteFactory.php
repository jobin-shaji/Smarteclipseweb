<?php

use Faker\Generator as Faker;

$factory->define(App\Modules\Route\Models\Route::class, function (Faker $faker){
    return [
        'name' => $faker->name,
        'route_code' => str_random(),
        'bus_type_id' => rand(1,3),
        'from_stage_id' => rand(1,3),
        'to_stage_id' => rand(1,3),
        'depot_id'=>rand(1,3),
        'status' => rand(0,1),
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Modules\Vehicle\Models\Vehicle::class, function (Faker $faker) {
     return [
        'register_number' => str_random(),
        'bus_type_id'=>1,
        'bus_occupancy'=>$faker->numberBetween($min=50,$max=150),
        'speed_limit'=>$faker->numberBetween($min=50,$max=150),
        'depot_id'=>1,
        'state_id'=>18,
        'status'=>1
    ];
});

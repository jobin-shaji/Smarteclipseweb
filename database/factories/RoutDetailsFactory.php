<?php

use Faker\Generator as Faker;

$factory->define(App\Modules\Route\Models\RouteDetails::class, function (Faker $faker) {
    return [
        'route_id' =>rand(1,6),
        'stage_id' =>rand(1,6),
        'km_from_start' => rand(20,200),
        'status' =>1
    ];
});

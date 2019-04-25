<?php

use Faker\Generator as Faker;

$factory->define(App\Modules\Etm\Models\Etm::class, function (Faker $faker) {
    return [
        "name" =>$faker->name,
        "imei" =>rand(1,15),
        "purchase_date" =>'2019-01-03',
        "version" =>'1.0',
        "state_id" =>18,
        "depot_id"=>1,
        "status" =>rand(0,1),
    ];
});

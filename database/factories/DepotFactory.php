<?php

use Faker\Generator as Faker;

$factory->define(App\Modules\Depot\Models\Depot::class, function (Faker $faker) {
 
        return [
        'name' => str_random(5),
        'code'=>str_random(3),
        'district_id'=>rand(274, 287),
        'state_id'=>18,
        'status'=>1
       ];
    
});

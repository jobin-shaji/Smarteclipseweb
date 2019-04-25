<?php

use Faker\Generator as Faker;

$factory->define(App\Modules\Employee\Models\Employee::class, function (Faker $faker) {
    return [
        'employee_code'=> str_random(),
        'name' => $faker->name,
        'employee_designation_id' => rand(1,3),
        'address' => $faker->address,
        'employee_dob' => '1996-05-10',
        'phone_number' => 85455845,
        'blood_group_id' => rand(1,8),
        'employee_pf_no' => $faker->numberBetween($min=50,$max=150),
        'employment_type_id' => rand(1,3),
        'depot_id' => 1, 
        'state_id' => 18, 
        'username' => str_random(),
        'status'=> rand(0,1),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret,
        'created_by' => 1,
        'deleted_by' =>1
    ];
});



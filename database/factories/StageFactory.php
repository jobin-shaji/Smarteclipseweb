<?php

use Faker\Generator as Faker;

$factory->define(App\Modules\Stage\Models\Stage::class, function (Faker $faker) {
	$number = 1;

	$placeName=["Angamaly","Telk","Athani","Aluva","Kalamassery","Muttom","Edapally","Valanchery","Koppam","Pattambi","Amayoor","Valiyakun","Edappal","Mukurushi","Kottayam","Pala","Thamarashery","Chalakudi","Kumbala","Aroor","Thekumpuram","Petta"];
    return [
      "name"=> $faker->randomElement($placeName),
      "code"=>str_random(3),
      "state_id"=>18,
      "depot_id"=>rand(1,10),
      "status"=>1
    ];
});

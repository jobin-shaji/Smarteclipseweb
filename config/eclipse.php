<?php


return array(
   'offline_time'                => "-360 minutes",
   'connection_lost_time_motion' => "-3 minutes",
   'connection_lost_time_halt'   => "-11 minutes",
   'connection_lost_time_sleep'  => "-120 minutes",
   //'connection_lost_time_sleep' => "-11 minutes",

   'keys' => array(
      'googleMap'    => env("GOOGLE_MAP_API_KEY"),
   ),

   'urls' => [
      'ms_alerts'    => env("URL_MS_ALERTS")
   ],

   'database_name'   => env("DB_DATABASE"),

   //PLAN BASED CONFIGURATIONS
   'PLANS' => [
      [ 'ID'=> 0, 'NAME' => 'FREEBIES'],
      [ 'ID'=> 1, 'NAME' => 'FUNDAMENTAL'],
      [ 'ID'=> 2, 'NAME' => 'SUPERIOR'],
      [ 'ID'=> 3, 'NAME' => 'PRO']
   ],

   //OFFLINE DURATION FOR DEVICE STATUS REPORT
   'OFFLINE_DURATION'   => env("OFFLINE_DURATION"),

   //PLAN BASED CONFIGURATIONS
   'DEVICE_STATUS'  => [
      'ALL'                => '0',
      'TAGGED'             => '1',
      'UNTAGGED'           => '2',
      'NOT_YET_ACTIVATED'  => '3'
   ],
);
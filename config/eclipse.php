<?php


return array(
   'offline_time' => "-360 minutes",
   'connection_lost_time_motion' => "-3 minutes",
   'connection_lost_time_halt' => "-11 minutes",
   'connection_lost_time_sleep' => "-11 minutes",
   'keys' => array(
      'googleMap' => env("GOOGLE_MAP_API_KEY"),
   ),
   'urls' => [
      'ms_alerts' => env("URL_MS_ALERTS")
   ]
);
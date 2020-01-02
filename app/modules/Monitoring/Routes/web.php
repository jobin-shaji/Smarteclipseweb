<?php

Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Monitoring\Controllers' ] , function() {

Route::get('/monitor','MonitorController@getVehicleList')->name('monitor_vehicle');
Route::post('/allvehicle-list','MonitorController@getVehicleData')->name('allvehicle.list');
});


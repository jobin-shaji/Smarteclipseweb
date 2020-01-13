<?php

Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Monitoring\Controllers' ] , function() {

Route::get('/monitor','MonitorController@getVehicleList')->name('monitor_vehicle');
Route::post('/allvehicle-list','MonitorController@getVehicleData')->name('allvehicle.list');
Route::post('/allvehicle-alert-list','MonitorController@getVehicleAlertData')->name('allvehicle-alert.list');
Route::post('/check-emergency-alerts','MonitorController@getEmergencyalerts')->name('check-emergency-alerts');

Route::get('/monitor-map','MonitorController@getAlertMap')->name('alert-map');

});


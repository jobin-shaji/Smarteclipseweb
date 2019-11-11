<?php 

Route::group(['namespace' => 'App\Modules\GpsConfig\Controllers' ] , function() {

Route::get('/gps-config','GpsConfigController@gpsConfigListPage')->name('gps-config');
Route::post('/gpsconfig-list','GpsConfigController@getAllGpsConfig')->name('gpsconfig-list');

});
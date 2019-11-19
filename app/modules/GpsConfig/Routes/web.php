<?php 

	Route::group(['middleware' => ['web','auth','role:operations'] ,'namespace' => 'App\Modules\GpsConfig\Controllers' ] , function() {
	Route::get('/gps-config','GpsConfigController@gpsConfigListPage')->name('gps-config');
	Route::post('/gpsconfig-list','GpsConfigController@getAllGpsConfig')->name('gpsconfig-list');
	Route::get('/all-gps-config','GpsConfigController@allGpsConfigListPage')->name('all-gps-config');
	Route::post('/all-gpsconfig-list','GpsConfigController@getAllGpsConfigList')->name('all-gpsconfig-list');
});
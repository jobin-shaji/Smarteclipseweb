<?php 

	Route::group(['middleware' => ['web','auth','role:operations'] ,'namespace' => 'App\Modules\GpsConfig\Controllers' ] , function() {
	Route::get('/gps-config','GpsConfigController@gpsConfigListPage')->name('gps-config');
	Route::post('/gpsconfig-list','GpsConfigController@getAllGpsConfig')->name('gpsconfig-list');
	Route::get('/all-gps-config','GpsConfigController@allGpsConfigListPage')->name('all-gps-config');
	Route::post('/all-gpsconfig-list','GpsConfigController@getAllGpsConfigList')->name('all-gpsconfig-list');
});
	Route::group(['namespace' => 'App\Modules\GpsConfig\Controllers' ] , function() {
	Route::get('/gps-config-public','GpsConfigController@gpsConfigListPagePublic')->name('gps-config-public');
	Route::post('/piblic-gpsconfig-list','GpsConfigController@getAllGpsConfigPublic')->name('public-gpsconfig-list');
	
});

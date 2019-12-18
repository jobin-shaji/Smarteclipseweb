<?php 

Route::group(['middleware' => ['web','auth','role:operations'] ,'namespace' => 'App\Modules\GpsConfig\Controllers' ] , function() {
	Route::get('/gps-config','GpsConfigController@gpsConfigListPage')->name('gps-config');
	Route::post('/gpsconfig-list','GpsConfigController@getAllGpsConfig')->name('gpsconfig-list');
	Route::get('/all-gps-config','GpsConfigController@allGpsConfigListPage')->name('all-gps-config');
	Route::post('/all-gpsconfig-list','GpsConfigController@getAllGpsConfigList')->name('all-gpsconfig-list');

	//processed data
	Route::get('/gps-records','GpsRecordController@gpsDateWiseRecord')->name('gps.records');
	Route::post('/gps-records-list','GpsRecordController@gpsDateWiseRecordList')->name('gps.records.list');
	Route::post('/gps-processed-records/export','GpsRecordController@exportProcessedData')->name('gps.processed.records.export');
	
	//unprocessed data
	Route::get('/gps-unprocessed-records','GpsRecordController@gpsUnprocessedDateWiseRecord')->name('gps.unprocessed.records');
	Route::post('/gps-unprocessed-records-list','GpsRecordController@gpsUnprocessedDateWiseRecordList')->name('gps.unprocessed.records.list');
	Route::post('/gps-unprocessed-records/export','GpsRecordController@exportUnprocessedData')->name('gps.unprocessed.records.export');
});
Route::group(['namespace' => 'App\Modules\GpsConfig\Controllers' ] , function() {
	Route::get('/gps-config-public','GpsConfigController@gpsConfigListPagePublic')->name('gps-config-public');
	Route::post('/piblic-gpsconfig-list','GpsConfigController@getAllGpsConfigPublic')->name('public-gpsconfig-list');
	
});

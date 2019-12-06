<?php 

	Route::group(['middleware' => ['web','auth','role:root'] ,'namespace' => 'App\Modules\Configuration\Controllers' ] , function() {

	Route::get('/configuration-create','ConfigurationController@create')->name('configuration.create');
	Route::post('/configuration-create','ConfigurationController@save')->name('configuration.create.p');

	
	// Route::post('/gpsconfig-list','ConfigurationController@getAllGpsConfig')->name('gpsconfig-list');
	// Route::get('/all-gps-config','ConfigurationController@allGpsConfigListPage')->name('all-gps-config');
	// Route::post('/all-gpsconfig-list','ConfigurationController@getAllGpsConfigList')->name('all-gpsconfig-list');
});


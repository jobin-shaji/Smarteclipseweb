<?php 

	Route::group(['middleware' => ['web','auth','role:root'] ,'namespace' => 'App\Modules\Configuration\Controllers' ] , function() {

	Route::get('/configuration-create','ConfigurationController@create')->name('configuration.create');
	Route::post('/configuration-create','ConfigurationController@save')->name('configuration.create.p');
	Route::post('/get-config-data','ConfigurationController@getConfiguration')->name('get-gps-data-hlm');
	
	Route::get('/trip-report-configuration-list','ConfigurationController@tripReportConfigList')->name('trip-report.configuration-list');
	Route::post('/trip-report-vehicle-configuration-update','ConfigurationController@tripReportConfigUpdate')->name('trip-report-vehicle-configuration.update');
	

	
});


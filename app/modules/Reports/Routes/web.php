<?php 

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Reports\Controllers' ] , function() {


	// geofence report 
	Route::get('/geofence-report','GeofenceReportController@geofenceReport')->name('geofence-report');
	Route::post('/geofence-report-list','GeofenceReportController@geofenceReportList')->name('geofence-report-list');

	// alert report 
	Route::get('/alert-report','AlertReportController@alertReport')->name('alert-report');

	// tracking report 
	Route::get('/tracking-report','TrackingReportController@trackingReport')->name('tracking-report');

	// route deviation report 
	Route::get('/route-deviation-report','RouteDeviationReportController@routeDeviationReport')->name('route-deviation-report');
 	Route::post('/route-deviation-report-list','RouteDeviationReportController@routeDeviationReportList')->name('route-deviation-report-list');

});


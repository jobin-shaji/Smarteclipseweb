<?php 

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Reports\Controllers' ] , function() {


	// geofence report 
	Route::get('/geofence-report','GeofenceReportController@geofenceReport')->name('geofence-report');
	Route::post('/geofence-report-list','GeofenceReportController@geofenceReportList')->name('geofence-report-list');

	// alert report 
	Route::get('/alert-report','AlertReportController@alertReport')->name('alert-report');
	Route::post('/alert-report-list','AlertReportController@alertReportList')->name('alert-report-list');
	Route::get('/alert/report/{id}/mapview','AlertReportController@location')->name('alert.report.mapview');

	Route::post('/alert/report/show','AlertReportController@alertmap')->name('alert.report.show');
	// tracking report 
	Route::get('/tracking-report','TrackingReportController@trackingReport')->name('tracking-report');
	Route::post('/track-report-list','TrackingReportController@trackReportList')->name('track-report-list');

	// route deviation report 
	Route::get('/route-deviation-report','RouteDeviationReportController@routeDeviationReport')->name('route-deviation-report');
 	Route::post('/route-deviation-report-list','RouteDeviationReportController@routeDeviationReportList')->name('route-deviation-report-list');



});


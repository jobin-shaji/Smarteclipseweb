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

		Route::post('/alert-report/export','AlertReportController@export')->name('alert.report.export');


		Route::post('/formany-driver-report/export','AlertReportController@formanydriverExport')->name('formany-driver-report.export');

	// tracking report 
	Route::get('/tracking-report','TrackingReportController@trackingReport')->name('tracking-report');
	Route::post('/track-report-list','TrackingReportController@trackReportList')->name('track-report-list');

	// route deviation report 
	Route::get('/route-deviation-report','RouteDeviationReportController@routeDeviationReport')->name('route-deviation-report');
 	Route::post('/route-deviation-report-list','RouteDeviationReportController@routeDeviationReportList')->name('route-deviation-report-list');

 	// harsh braking report 
	Route::get('/harsh-braking-report','HarshBrakingReportController@harshBrakingReport')->name('harsh-braking-report');
	Route::post('/harsh-braking-report-list','HarshBrakingReportController@harshBrakingReportList')->name('harsh-braking-report-list');
	
//sudden acceleration report
	Route::get('/sudden-acceleration-report','SuddenAccelerationReportController@suddenAccelerationReport')->name('sudden-acceleration-report');
Route::post('/sudden-acceleration-report-list','SuddenAccelerationReportController@suddenAccelerationReportList')->name('sudden-acceleration-report-list');

//total km report
	Route::get('/total-km-report','TotalKMReportController@totalKMReport')->name('total-km-report');

	
//Daily KM report
	Route::get('/daily-km-report','DailyKMReportController@dailyKMReport')->name('daily-km-report');
//over-speed-report
	Route::get('/over-speed-report','OverSpeedReportController@overSpeedReport')->name('over-speed-report');
	Route::post('/over-speed-report-list','OverSpeedReportController@overSpeedReportList')->name('over-speed-report-list');
	//zigzag-driving-report
	Route::get('/zigzag-driving-report','ZigZagDrivingReportController@zigZagDrivingReport')->name('zigzag-driving-report');

	Route::post('/zigzag-driving-report-list','ZigZagDrivingReportController@zigZagDrivingReportList')->name('zigzag-driving-report-list');

	//accident-imapct-alert-report
	Route::get('/accident-imapct-alert-report','AccidentImpactAlertReportController@accidentImpactAlertReport')->name('accident-imapct-alert-report');
Route::post('/accident-impact-alert-report-list','AccidentImpactAlertReportController@accidentImpactAlertReportList')->name('accident-impact-alert-report-list');


	//accident-imapct-alert-report
	Route::get('/terain-roads-condition-operation-temperature-report','TerainRoadsConditionOperationTemperatureReportController@terainRoadConditionReport')->name('terain-roads-condition-operation-temperature-report');
	
Route::get('/idle-report','IdleReportController@idleReport')->name('idle-report');
Route::post('/idle-report-list','IdleReportController@idleReportList')->name('idle-report-list');


Route::get('/offline-report','OfflineReportController@accidentImpactAlertReport')->name('offline-report');
Route::get('/mainbattery-disconnect-report','MainBatteryDisconnectReportController@mainBatteryDisconnectReport')->name('mainbattery-disconnect-report');
Route::post('/mainbattery-disconnect-report-list','MainBatteryDisconnectReportController@mainBatteryDisconnectReportList')->name('mainbattery-disconnect-report-list');


});


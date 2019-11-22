<?php 

Route::group(['middleware' => ['web','auth','role:client|school'] , 'namespace' => 'App\Modules\Reports\Controllers' ] , function() {


	// geofence report 
	Route::get('/geofence-report','GeofenceReportController@geofenceReport')->name('geofence-report');
	Route::post('/geofence-report-list','GeofenceReportController@geofenceReportList')->name('geofence-report-list');
	Route::post('/geofence-report/export','GeofenceReportController@export')->name('geofence.report.export');

	// alert report 
	Route::get('/alert-report','AlertReportController@alertReport')->name('alert-report');
	Route::get('/alert-report-list','AlertReportController@alertReportList')->name('alert-report-list');
	// Route::post('/alert-report-list-demo','AlertReportController@alertReportListDemo')->name('alert-report-list-demo');

	Route::get('/alert/report/{id}/mapview','AlertReportController@location')->name('alert.report.mapview');
	Route::post('/alert/report/show','AlertReportController@alertmap')->name('alert.report.show');
		Route::post('/alert-report/export','AlertReportController@export')->name('alert.report.export');
	// tracking report 
	Route::get('/tracking-report','TrackingReportController@trackingReport')->name('tracking-report');
	Route::post('/track-report-list','TrackingReportController@trackReportList')->name('track-report-list');
	Route::post('/track-report/export','TrackingReportController@export')->name('track.report.export');

	// route deviation report 
	Route::get('/route-deviation-report','RouteDeviationReportController@routeDeviationReport')->name('route-deviation-report');
 	Route::post('/route-deviation-report-list','RouteDeviationReportController@routeDeviationReportList')->name('route-deviation-report-list');
 	Route::post('/route-report/export','RouteDeviationReportController@export')->name('route.report.export');


 	// harsh braking report 
	Route::get('/harsh-braking-report','HarshBrakingReportController@harshBrakingReport')->name('harsh-braking-report');
	Route::post('/harsh-braking-report-list','HarshBrakingReportController@harshBrakingReportList')->name('harsh-braking-report-list');
	Route::post('/harsh-braking-report/export','HarshBrakingReportController@export')->name('harsh.braking.report.export');
	
//sudden acceleration report
	Route::get('/sudden-acceleration-report','SuddenAccelerationReportController@suddenAccelerationReport')->name('sudden-acceleration-report');
Route::post('/sudden-acceleration-report-list','SuddenAccelerationReportController@suddenAccelerationReportList')->name('sudden-acceleration-report-list');
Route::post('/sudden-acceleration-report/export','SuddenAccelerationReportController@export')->name('sudden.acceleration.report.export');

//total km report
	Route::get('/total-km-report','TotalKMReportController@totalKMReport')->name('total-km-report');
Route::post('/totalkm-report-list','TotalKMReportController@totalKMReportList')->name('totalkm-report-list');
Route::post('/total-km-report/export','TotalKMReportController@export')->name('total.km.report.export');


// km repor
	Route::get('/km-report','TotalKMReportController@kmReport')->name('km-report');
Route::post('/km-report-list','TotalKMReportController@kmReportList')->name('km-report-list');
Route::post('/km-report/export','TotalKMReportController@kmExport')->name('km.report.export');


	
//Daily KM report
	Route::get('/daily-km-report','DailyKMReportController@dailyKMReport')->name('daily-km-report');
Route::post('/dailykm-report-list','DailyKMReportController@dailyKMReportList')->name('dailykm-report-list');
Route::post('/daily-km-report/export','DailyKMReportController@export')->name('daily.km.report.export');

//over-speed-report
	Route::get('/over-speed-report','OverSpeedReportController@overSpeedReport')->name('over-speed-report');
	Route::post('/over-speed-report-list','OverSpeedReportController@overSpeedReportList')->name('over-speed-report-list');
Route::post('/over-speed-report/export','OverSpeedReportController@export')->name('over.speed.report.export');

	//zigzag-driving-report
	Route::get('/zigzag-driving-report','ZigZagDrivingReportController@zigZagDrivingReport')->name('zigzag-driving-report');

	Route::post('/zigzag-driving-report-list','ZigZagDrivingReportController@zigZagDrivingReportList')->name('zigzag-driving-report-list');
	Route::post('/zigzag-driving-report/export','ZigZagDrivingReportController@export')->name('zigzag.driving.report.export');


	//accident-imapct-alert-report
	Route::get('/accident-imapct-alert-report','AccidentImpactAlertReportController@accidentImpactAlertReport')->name('accident-imapct-alert-report');
Route::post('/accident-impact-alert-report-list','AccidentImpactAlertReportController@accidentImpactAlertReportList')->name('accident-impact-alert-report-list');

	Route::post('/accident-imapct-alert-report/export','AccidentImpactAlertReportController@export')->name('accident.imapct.alert.report.export');



	//accident-imapct-alert-report
	Route::get('/terain-roads-condition-operation-temperature-report','TerainRoadsConditionOperationTemperatureReportController@terainRoadConditionReport')->name('terain-roads-condition-operation-temperature-report');
	
	Route::get('/idle-report','IdleReportController@idleReport')->name('idle-report');
	Route::post('/idle-report-list','IdleReportController@idleReportList')->name('idle-report-list');
	Route::post('/idle-report/export','IdleReportController@export')->name('idle.report.export');

Route::get('/parking-report','ParkingReportController@parkingReport')->name('parking-report');
	Route::post('/parking-report-list','ParkingReportController@parkingReportList')->name('parking-report-list');
	Route::post('/parking-report/export','ParkingReportController@export')->name('parking.report.export');


Route::get('/offline-report','OfflineReportController@accidentImpactAlertReport')->name('offline-report');

Route::get('/mainbattery-disconnect-report','MainBatteryDisconnectReportController@mainBatteryDisconnectReport')->name('mainbattery-disconnect-report');
Route::post('/mainbattery-disconnect-report-list','MainBatteryDisconnectReportController@mainBatteryDisconnectReportList')->name('mainbattery-disconnect-report-list');
Route::post('/main-battery-disconnect-report/export','MainBatteryDisconnectReportController@export')->name('main.battery.disconnect.report.export');


// test mode change
  Route::get('/mode-changes','TrackingReportController@modeTime')->name('mode-changes');

// test mode change

});

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Reports\Controllers' ] , function() {

	Route::get('/log-report','DeviceLogReportController@logReport')->name('log-report');
	Route::post('/log-report-list','DeviceLogReportController@logReportList')->name('log-report-list');
	// Route::post('/track-report/export','TrackingReportController@export')->name('track.report.export');
});

Route::group(['middleware' => ['web','auth','role:school'] , 'namespace' => 'App\Modules\Reports\Controllers' ] , function() {

	Route::get('/pickup-dropoff-report-based-on-student','PickupDropoffReportController@pickupReportBasedOnStudent')->name('pickup.dropoff.report.based.on.student');
	// Route::post('/log-report-list','DeviceLogReportController@logReportList')->name('log-report-list');

	//missed-student-report
	Route::get('/missed-student-report','missedStudentReportController@missedStudentReport')->name('missed-student-report');
	// Route::post('/log-report-list','DeviceLogReportController@logReportList')->name('log-report-list');
	//pickup-drop-off-report-based-on-bus
	Route::get('/pickup-dropoff-report-based-on-bus','PickupDropoffReportController@pickupReportBasedOnBus')->name('pickup-dropoff-report-based-on-bus');
	// Route::post('/log-report-list','DeviceLogReportController@logReportList')->name('log-report-list');

	// special class bus
	Route::get('/special-class-bus-schedule-report','SpecialClassBusScheduleController@specialClassBusSchedule')->name('special-class-bus-schedule-report');
	// Route::post('/log-report-list','DeviceLogReportController@logReportList')->name('log-report-list');

	//parent information report
	Route::get('/parent-information-report','ParentInformationReportController@parentInformationReport')->name('parent-information-report');
	// Route::post('/log-report-list','DeviceLogReportController@logReportList')->name('log-report-list');

	////student-wise-usage-report
	Route::get('/student-wise-usage-report','StudentWiseUsageReportController@studentWiseUsageReport')->name('student-wise-usage-report');
	// Route::post('/log-report-list','DeviceLogReportController@logReportList')->name('log-report-list');

	////nfc card report
	Route::get('/nfc-card-report','NfcCardReportController@nfcCardReport')->name('nfc-card-report');
	// Route::post('/log-report-list','DeviceLogReportController@logReportList')->name('log-report-list');


});
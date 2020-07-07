<?php 
    Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\TripReport\Controllers' ] , function() {
    Route::get('/vehicle-trip-report-config','VehicleTripReportController@getVehicleTripReportConfig')->name('vehicle-trip-report-config');
    Route::post('/end-user-plan','VehicleTripReportController@getPlanOfEndUser')->name('end-user-plan');
    Route::post('/end-user-vehicle','VehicleTripReportController@getVehiclesBasedOnClient')->name('end.user.vehicle');
	Route::post('/vehicle-trip-report-config-create','VehicleTripReportController@vehicletripreportsave')->name('vehicle.trip.report.config.create.p');    
    Route::get('trip-report-configuration-delete/{id}','VehicleTripReportController@vehicletripreportdelete')->name('trip.report.configuration.delete');
	
});

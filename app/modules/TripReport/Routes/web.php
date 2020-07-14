<?php 
    Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\TripReport\Controllers' ] , function() {
    Route::get('/vehicle-trip-report-config','VehicleTripReportController@getVehicleTripReportConfig')->name('vehicle-trip-report-config');
    Route::post('/end-user-plan','VehicleTripReportController@getPlanOfEndUser')->name('end-user-plan');
    Route::post('/end-user-vehicle','VehicleTripReportController@getVehiclesBasedOnClient')->name('end.user.vehicle');
	Route::post('/trip-report-subscription-create','VehicleTripReportController@saveTripReportSubscription')->name('trip.report.subscriptions.create.p');    
    Route::get('trip-report-subscription-vehicles/{id}','VehicleTripReportController@tripReportSubscriptionVehiclesList')->name('trip.report.subscription.vehicles');
    Route::post('trip-report-subscription-vehicles/{id}','VehicleTripReportController@saveVehicleSubscription')->name('vehicle.subscriptions.create.p');
    Route::get('trip-report-configuration-delete/{id}','VehicleTripReportController@tripReportSubscriptionDelete')->name('trip.report.configuration.delete');
    Route::get('trip-report-vehicle-delete/{id}','VehicleTripReportController@tripReportVehicleDelete')->name('trip.report.configuration.delete');
    Route::post('subscription_validation','VehicleTripReportController@getSubscriptionValidation')->name('subscription.validation');
    
	
});

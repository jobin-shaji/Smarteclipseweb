<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\TripReport\Controllers' ] , function() {
    Route::get('/vehicle-trip-report-config','TripReportController@getVehicleTripReportConfig')->name('vehicle-trip-report-config');
    Route::post('/end-user-plan','TripReportController@getPlanOfEndUser')->name('end-user-plan');
});

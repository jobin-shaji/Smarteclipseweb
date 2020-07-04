<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\TripReport\Controllers' ] , function() {
    Route::get('/vehicle-trip-report-config','TripReportController@getTripReportConfig')->name('vehicle-trip-report-config');
   
});

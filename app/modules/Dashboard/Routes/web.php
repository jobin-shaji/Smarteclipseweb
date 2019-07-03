<?php


Route::group(['middleware' => ['web','auth'] ,'namespace' => 'App\Modules\Dashboard\Controllers' ] , function () {

        Route::get('/home', 'DashboardController@index')->name('dashboard');
        Route::post('/dash-count','DashboardController@dashCount')->name('dash.count');

        Route::post('/dashboard/getlocation','DashboardController@getLocation')->name('dashboard.getlocation');
        Route::post('/dashboard-vehicle-list','DashboardController@vehicleList')->name('dashboard-vehicle-list');

        Route::post('/vehicle-detail','DashboardController@vehicleDetails')->name('vehicle.detail');
        Route::post('/dash-vehicle-track','DashboardController@dashVehicleTrack')->name('dash.vehicle.track');

        Route::post('/dashboard-track','DashboardController@vehicleTrackList')->name('/dashboard-track');
        Route::post('/driver-score','DashboardController@driverScore')->name('driver.score');

         Route::post('/dashboard-track-vehicle-mode','DashboardController@vehicleMode')->name('/dashboard-track-vehicle-mode');
});
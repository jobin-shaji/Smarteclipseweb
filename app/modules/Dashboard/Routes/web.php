<?php


Route::group(['middleware' => ['web','auth'] ,'namespace' => 'App\Modules\Dashboard\Controllers' ] , function () {
     Route::get('/home', 'DashboardController@index')->name('dashboard');
        Route::post('/dash-count','DashboardController@dashCount')->name('dash.count');
       
        Route::post('/dashboard/getlocation','DashboardController@getLocation')->name('dashboard.getlocation');
        Route::post('/dashboard-vehicle-list','DashboardController@vehicleList')->name('dashboard-vehicle-list');
        Route::post('/vehicle-detail','DashboardController@vehicleDetails')->name('vehicle.detail');
        Route::post('/dash-vehicle-track','DashboardController@dashVehicleTrack')->name('dash.vehicle.track');
        Route::post('/dashboard-track','DashboardController@vehicleTrackList')->name('/dashboard-track');
        
        Route::post('/emergency-alert','DashboardController@emergencyAlerts')->name('emergency.alerts');

        Route::post('/emergency-alert/verify','DashboardController@verifyEmergencyAlert')->name('emergency-alert.verify');

        Route::post('/get-location','DashboardController@getLocationFromLatLng')->name('get.location');

         Route::post('/dashboard-track-vehicle-mode','DashboardController@vehicleMode')->name('/dashboard-track-vehicle-mode');

           Route::post('/location-search','DashboardController@locationSearch')->name('/location-search');

            Route::post('/notification', 'DashboardController@notification')->name('notification');

            
});
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Dashboard\Controllers' ] , function() {
    Route::post('/root-gps-sale','DashboardController@rootGpsSale')->name('root.gps.sale');
    Route::post('/root-gps-user','DashboardController@rootGpsUsers')->name('root.gps.user');
});
Route::group(['middleware' => ['web','auth','role:dealer'] , 'namespace' => 'App\Modules\Dashboard\Controllers' ] , function() {
    Route::post('/dealer-gps-sale','DashboardController@dealerGpsSale')->name('dealer.gps.sale');
    Route::post('/dealer-gps-user','DashboardController@dealerGpsUsers')->name('dealer.gps.user');
});

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Dashboard\Controllers' ] , function() {
    Route::post('/sub-dealer-gps-sale','DashboardController@subDealerGpsSale')->name('sub-dealer.gps.sale');
    Route::post('/sub-dealer-gps-user','DashboardController@subDealerGpsUsers')->name('sub-dealer.gps.user');
});

    // Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Dashboard\Controllers' ] , function() {
    //  Route::get('/home', 'DashboardController@clientDashboardindex')->name('client.dashboard');
    //     Route::post('/dash-count','DashboardController@dashCount')->name('dash.count');
    // });
<?php
Route::group(['middleware' => ['web','auth'] ,'namespace' => 'App\Modules\Dashboard\Controllers' ] , function () {
    Route::get('/home', 'DashboardController@index')->name('dashboard');
    Route::post('/dash-count','DashboardController@dashCount')->name('dash.count');
    // hide for remove 
    // 2020-05-18
    // Route::post('/dashboard/getlocation','DashboardController@getLocation')->name('dashboard.getlocation');
    // hide for remove 
    // 2020-05-18
    Route::post('/dashboard-vehicle-list','DashboardController@vehicleList')->name('dashboard-vehicle-list');
    Route::post('/vehicle-detail','DashboardController@vehicleDetails')->name('vehicle.detail');
    Route::post('/dash-vehicle-track','DashboardController@dashVehicleTrack')->name('dash.vehicle.track');
    Route::post('/dash-vehicle-user-track','DashboardController@dashVehicleUserTrack')->name('dash.vehicle.user.track');
    Route::post('/dashboard-track','DashboardController@vehicleTrackList')->name('/dashboard-track');

    Route::post('/GetDashVehiclesView','DashboardController@GetDashVehiclesView')->name('GetDashVehiclesView');
    Route::post('/AddVehicle','DashboardController@AddVehicle')->name('AddVehicle');
    Route::post('/UserActivities','DashboardController@UserActivities')->name('UserActivities');
    Route::post('/AdminListVehicles','DashboardController@AdminListVehicles')->name('AdminListVehicles');
    Route::post('/AdminListUsers','DashboardController@AdminListUsers')->name('AdminListUsers');


    
    Route::post('/GetEugInfoView','DashboardController@GetEugInfoView')->name('GetEugInfoView');
    

    Route::post('/emergency-alert/verify','DashboardController@verifyEmergencyAlert')->name('emergency-alert.verify');

    Route::post('/get-location','DashboardController@getLocationFromLatLng')->name('get.location');
    Route::post('/dashboard-track-vehicle-mode','DashboardController@vehicleMode')->name('/dashboard-track-vehicle-mode');
    Route::post('/location-search','DashboardController@locationSearch')->name('/location-search');
    Route::post('/notification', 'DashboardController@notification')->name('notification');
    /**location name */
    Route::post('/vehicle-location-name','DashboardController@getAddress')->name('vehicle.location.name');
    /**location name */


    Route::get('/map-user-view', 'DashboardController@mapUserView')->name('map.user.view');
});
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Dashboard\Controllers' ] , function() {
    Route::get('/map-view', 'DashboardController@mapView')->name('map.view');
    Route::post('/root-vehicle-mode-count','DashboardController@vehicleModeCount')->name('root.vehicle.mode.count');
    Route::post('/root-gps-sale','DashboardController@rootGpsSale')->name('root.gps.sale');
    Route::post('/root-gps-client-sale','DashboardController@rootGpsClientSale')->name('root.gps.client.sale');

    Route::post('/root-gps-user','DashboardController@rootGpsUsers')->name('root.gps.user');
});
Route::group(['middleware' => ['web','auth','role:user'] , 'namespace' => 'App\Modules\Dashboard\Controllers' ] , function() {

    
    /*
    Route::post('/root-vehicle-mode-count','DashboardController@vehicleModeCount')->name('root.vehicle.mode.count');
    Route::post('/root-gps-sale','DashboardController@rootGpsSale')->name('root.gps.sale');
    Route::post('/root-gps-client-sale','DashboardController@rootGpsClientSale')->name('root.gps.client.sale');

    Route::post('/root-gps-user','DashboardController@rootGpsUsers')->name('root.gps.user');
    */
});
Route::group(['middleware' => ['web','auth','role:dealer'] , 'namespace' => 'App\Modules\Dashboard\Controllers' ] , function() {
    Route::post('/dealer-gps-sale','DashboardController@dealerGpsSale')->name('dealer.gps.sale');
    Route::post('/dealer-gps-client-sale','DashboardController@dealerGpsClientSale')->name('dealer.gps.client.sale');
   
    Route::post('/dealer-gps-user','DashboardController@dealerGpsUsers')->name('dealer.gps.user');
});

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Dashboard\Controllers' ] , function() {
    Route::post('/sub-dealer-gps-sale','DashboardController@subDealerGpsSale')->name('sub-dealer.gps.sale');
    Route::post('/sub-dealer-gps-client-sale','DashboardController@subDealerGpsClientSale')->name('sub.dealer.gps.client.sale');
    Route::post('/sub-dealer-gps-user','DashboardController@subDealerGpsUsers')->name('sub-dealer.gps.user');
});

    // Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Dashboard\Controllers' ] , function() {
    //  Route::get('/home', 'DashboardController@clientDashboardindex')->name('client.dashboard');
    //     Route::post('/dash-count','DashboardController@dashCount')->name('dash.count');
    // });
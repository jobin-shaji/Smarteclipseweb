<?php


Route::group(['middleware' => ['web','auth'] ,'namespace' => 'App\Modules\Dashboard\Controllers' ] , function () {

        Route::get('/home', 'DashboardController@index')->name('dashboard');
        Route::post('/dash-count','DashboardController@dashCount')->name('dash.count');

        Route::post('/dashboard/getlocation','DashboardController@getLocation')->name('dashboard.getlocation');
        Route::post('/dashboard-vehicle-list','DashboardController@vehicleList')->name('dashboard-vehicle-list');

        Route::post('/vehicle-detail','DashboardController@vehicleDetails')->name('vehicle.detail');

});
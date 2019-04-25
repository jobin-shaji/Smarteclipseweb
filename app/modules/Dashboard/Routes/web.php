<?php


Route::group(['middleware' => ['web','auth'] ,'namespace' => 'App\Modules\Dashboard\Controllers' ] , function () {

        Route::get('/home', 'DashboardController@index')->name('dashboard');

        Route::post('/dash-count','DashboardController@dashCount')->name('dash.count');

});
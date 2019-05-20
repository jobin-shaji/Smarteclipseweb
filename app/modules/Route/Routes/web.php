<?php

Route::group(['middleware' => ['web','auth','role:client'] ,'namespace' => 'App\Modules\Route\Controllers' ] , function () {


Route::get('/route','RouteController@routeList')->name('route');
Route::post('/route-list','RouteController@getRouteList')->name('route-list');
Route::get('/route/create','RouteController@createRoute')->name('route.create');
Route::post('/route/save_route','RouteController@saveRoute')->name('route.create.p');
Route::get('/route/{id}/details','RouteController@details')->name('route.details');
Route::post('vehicle/delete','RouteController@deleteRoute')->name('vehicle.delete');
Route::post('vehicle/activate','RouteController@activateRoute')->name('vehicle.activate');


});
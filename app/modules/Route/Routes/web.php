<?php

Route::group(['middleware' => ['web','auth','role:client'] ,'namespace' => 'App\Modules\Route\Controllers' ] , function () {

Route::get('/route','RouteController@routeList')->name('route');
Route::post('/route-list','RouteController@getRouteList')->name('route-list');
Route::get('/route/create','RouteController@createRoute')->name('route.create');
Route::post('/route/save_route','RouteController@saveRoute')->name('route.create.p');
Route::get('/route/{id}/details','RouteController@details')->name('route.details');
Route::post('route/delete','RouteController@deleteRoute')->name('route.delete');
Route::post('route/activate','RouteController@activateRoute')->name('route.activate');

Route::get('/assign/route-vehicle','RouteController@AssignRouteList')->name('assign.route.vehicle');
Route::post('/assign/assign-route-vehicle-list','RouteController@getAssignRouteVehicleList')->name('assign-route-vehicle-list');


});
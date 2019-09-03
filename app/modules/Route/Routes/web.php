<?php

Route::group(['middleware' => ['web','auth','role:client|school'] ,'namespace' => 'App\Modules\Route\Controllers' ] , function () {

Route::get('/route','RouteController@routeList')->name('route');
Route::post('/route-list','RouteController@getRouteList')->name('route-list');
Route::get('/route/create','RouteController@createRoute')->name('route.create');
Route::post('/route/save_route','RouteController@saveRoute')->name('route.create.p');
Route::get('/route/{id}/details','RouteController@details')->name('route.details');
Route::post('route/delete','RouteController@deleteRoute')->name('route.delete');
Route::post('route/activate','RouteController@activateRoute')->name('route.activate');

Route::get('/assign/route-vehicle','RouteController@AssignRouteList')->name('assign.route.vehicle');
Route::post('/assign/assign-route-vehicle-list','RouteController@getAssignRouteVehicleList')->name('assign-route-vehicle-list');
Route::post('/already/assign-route','RouteController@alredyassignroutelist')->name('already.assign.route');

Route::get('/route-schedule','RouteController@routeScheduledList')->name('route-schedule');
Route::post('/route-schedule-list','RouteController@getrouteScheduledList')->name('route-schedule-list');
Route::get('/route/schedule','RouteController@scheduleRoute')->name('route.schedule');
Route::post('/route/save_schedule','RouteController@saveScheduleRoute')->name('route.schedule.p');
Route::post('/route/route-batch','RouteController@routeBatchData')->name('route.route-batch');
Route::post('/route/vehicle-driver','RouteController@routeVehicleDriverData')->name('route.vehicle-driver');
Route::get('/route/{id}/schedule-edit','RouteController@editScheduleRoute')->name('route.schedule-edit');
Route::post('/route/{id}/schedule-edit','RouteController@updateScheduleRoute')->name('route.schedule-update.p');
Route::post('/route/schedule-delete','RouteController@deleteScheduleRoute')->name('route.schedule-delete');
Route::post('/route/schedule-activate','RouteController@activateScheduleRoute')->name('route.schedule-activate');


});
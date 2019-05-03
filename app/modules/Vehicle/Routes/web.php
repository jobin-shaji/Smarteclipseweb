<?php

Route::group(['middleware' => ['web','auth','role:client'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {


Route::get('/vehicle','VehicleController@VehicleList')->name('vehicle');

Route::post('/vehicle-list','VehicleController@getVehicleList')->name('vehicle-list');
Route::get('/vehicles/create','VehicleController@createVehicle')->name('vehicles.create');
Route::post('/vehicles/save_vehicle','VehicleController@saveVehicle')->name('vehicles.create.p');
Route::get('/vehicles/{id}/edit','VehicleController@edit')->name('vehicle.edit');
Route::post('/vehicle/{id}/edit','VehicleController@update')->name('vehicles.update.p');
Route::get('/vehicles/{id}/details','VehicleController@details')->name('vehicles.details');
Route::post('vehicle/delete','VehicleController@deleteVehicle')->name('vehicle.delete');
Route::post('vehicle/activate','VehicleController@activateVehicle')->name('vehicle.activate');

});





Route::group(['middleware' => ['web','auth','role:root'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {

//VEHICLE TYPE
Route::get('/vehicle-types','VehicleController@vehicleTypeList')->name('vehicle-types');
Route::post('/vehicle-type-list','VehicleController@getVehicleTypeList')->name('vehicle-type-list');

Route::get('/vehicle-type/create','VehicleController@createVehicleType')->name('vehicle_type.create');
Route::post('/vehicle-type/save_vehicle_type','VehicleController@saveVehicleType')->name('vehicle-type.create.p');
Route::get('/vehicle-type/{id}/details','VehicleController@detailsVehicleType')->name('vehicle_type.details');
Route::get('/vehicle-type/{id}/edit','VehicleController@editVehicleType')->name('vehicle-type.edit');
Route::post('/vehicle_type/{id}/edit','VehicleController@updateVehicleType')->name('vehicle-type.update.p');
// Route::post('vehicle_type/delete','VehicleController@deleteVehicleType')->name('vehicle-type.delete');

});
<?php

Route::group(['middleware' => ['web','auth','role:state'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {


Route::get('/vehicles','VehicleController@VehicleList')->name('vehicles');

Route::post('/vehicle-list','VehicleController@getVehicleList')->name('vehicle-list');
Route::get('/vehicles/create','VehicleController@craeteVehicle')->name('vehicles.create');
Route::post('/vehicles/save_vehicle','VehicleController@saveVehicle')->name('vehicles.create.p');
Route::get('/vehicles/{id}/edit','VehicleController@edit')->name('vehicle.edit');
Route::post('/vehicle/{id}/edit','VehicleController@update')->name('vehicles.update.p');
Route::get('/vehicles/{id}/details','VehicleController@details')->name('vehicles.details');
Route::post('vehicle/delete','VehicleController@deleteVehicle')->name('vehicle.delete');
Route::post('vehicle/activate','VehicleController@activateVehicle')->name('vehicle.activate');


//VEHICLE TYPE
Route::get('/vehicle-types','VehicleController@vehicleTypeList')->name('vehicle-types');
Route::post('/vehicle-type-list','VehicleController@getVehicleTypeList')->name('vehicle-type-list');

Route::get('/vehicle-type/create','VehicleController@createVehicleType')->name('vehicle_type.create');
Route::post('/vehicle-type/save_vehicle_type','VehicleController@saveVehicleType')->name('vehicle-type.create.p');
Route::get('/vehicle-type/{id}/details','VehicleController@detailsVehicleType')->name('vehicle_type.details');
Route::get('/vehicle-type/{id}/edit','VehicleController@editVehicleType')->name('vehicle-type.edit');
Route::post('/vehicle_type/{id}/edit','VehicleController@updateVehicleType')->name('vehicle-type.update.p');
// Route::post('vehicle_type/delete','VehicleController@deleteVehicleType')->name('vehicle-type.delete');

Route::post('/vehicle-concession-add','VehicleController@vehicleConcessionAdd')->name('vehicle.concession.add');
Route::post('/vehicle-concession-remove','VehicleController@vehicleConcessionRemove')->name('vehicle.concession.remove');


});





Route::group(['middleware' => ['web','auth','role:depot'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {


Route::get('/vehicle-list','VehicleDepoController@VehicleList')->name('vehicles_depo');
Route::post('/vehicledepo-list','VehicleDepoController@getVehicleList')->name('vehicledepo-list');

});
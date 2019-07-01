<?php

Route::group(['middleware' => ['web','auth','role:client'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {


Route::get('/vehicle','VehicleController@vehicleList')->name('vehicle');

Route::post('/vehicle-list','VehicleController@getVehicleList')->name('vehicle-list');
Route::get('/vehicles/create','VehicleController@createVehicle')->name('vehicles.create');
Route::post('/vehicles/save_vehicle','VehicleController@saveVehicle')->name('vehicles.create.p');
Route::get('/vehicles/{id}/edit','VehicleController@edit')->name('vehicle.edit');
Route::post('/vehicle/{id}/edit','VehicleController@update')->name('vehicles.update.p');
Route::get('/vehicles/{id}/details','VehicleController@details')->name('vehicles.details');
Route::post('vehicle/delete','VehicleController@deleteVehicle')->name('vehicle.delete');
Route::post('vehicle/activate','VehicleController@activateVehicle')->name('vehicle.activate');

Route::get('/vehicles/{id}/documents','VehicleController@vehicleDocuments')->name('vehicle.documents');
Route::post('/vehicles/save_doc','VehicleController@saveDocuments')->name('vehicles.doc.p');
Route::get('/vehicle-doc/{id}/edit','VehicleController@vehicleDocumentEdit')->name('vehicle-doc.edit');
Route::post('/vehicle-doc/{id}/edit','VehicleController@vehicleDocumentUpdate')->name('vehicle-doc.update.p');
Route::get('vehicle-doc/{id}/delete','VehicleController@vehicleDocumentDelete')->name('vehicle-doc.delete');

Route::get('/vehicles/{id}/ota','VehicleController@vehicleOta')->name('vehicle.ota');
Route::post('/vehicle/{id}/ota-update','VehicleController@updateOta')->name('vehicles.ota.update.p');


Route::get('/vehicles/{id}/playback','VehicleController@playbackHMap')->name('vehicles.playback');

Route::post('/vehicles/location-playback','VehicleController@hmapLocationPlayback')->name('vehicles.location-playback');

Route::get('/vehicle-driver-log','VehicleController@vehicleDriverLogList')->name('vehicle-driver-log');

Route::post('/vehicle-driver-log-list','VehicleController@getVehicleDriverLogList')->name('vehicle-driver-log-list');




//////////////////////////////////Route in vehicle//////////////////////////////

Route::post('/vehicle-route/save_route','VehicleController@saveVehicleRoute')->name('vehicle-route.create.p');
Route::get('/vehicle-route/{id}/edit','VehicleController@editVehicleRoute')->name('vehicle-route.edit');
Route::post('/vehicle-route/{id}/edit','VehicleController@updateVehicleRoute')->name('vehicle-route.update.p');
Route::get('/vehicle-route/{id}/view','VehicleController@viewVehicleRoute')->name('vehicle-route.view');
Route::get('vehicle-route/{id}/delete','VehicleController@deleteVehicleRoute')->name('vehicle-route.delete');

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

//Vehicle List
Route::get('/vehicle-root','VehicleController@vehicleRootList')->name('vehicle-root');

Route::post('/vehicle-root-list','VehicleController@getVehicleRootList')->name('vehicle-root-list');
});

///////////////////////////////Location track////////////////////////////////////
Route::group(['middleware' => ['web','auth','role:root|dealer|sub_dealer|client'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {

Route::get('/vehicles/{id}/location','VehicleController@location')->name('vehicles.location');

Route::post('/vehicles/location-track','VehicleController@locationTrack')->name('vehicles.location-track');
});

//////////////////////////////////////////////////////////////////////////////////


Route::group(['middleware' => ['web','auth','role:dealer'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {

//Vehicle List
Route::get('/vehicle-dealer','VehicleController@vehicleDealerList')->name('vehicle-dealer');

Route::post('/vehicle-dealer-list','VehicleController@getVehicleDealerList')->name('vehicle-dealer-list');
});

Route::group(['middleware' => ['web','auth','role:sub_dealer'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {

//Vehicle List
Route::get('/vehicle-sub-dealer','VehicleController@vehicleSubDealerList')->name('vehicle-sub-dealer');

Route::post('/vehicle-sub-dealer-list','VehicleController@getVehicleSubDealerList')->name('vehicle-sub-dealer-list');

});



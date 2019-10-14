<?php

Route::group(['middleware' => ['web','auth','role:client|school'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {


Route::get('/vehicle','VehicleController@vehicleList')->name('vehicle');

Route::post('/vehicle-list','VehicleController@getVehicleList')->name('vehicle-list');
Route::get('/vehicles/create','VehicleController@createVehicle')->name('vehicles.create');
Route::post('/vehicles/save_vehicle','VehicleController@saveVehicle')->name('vehicles.create.p');
Route::get('/vehicles/{id}/details','VehicleController@details')->name('vehicles.details');
Route::post('vehicle/delete','VehicleController@deleteVehicle')->name('vehicle.delete');
Route::post('vehicle/activate','VehicleController@activateVehicle')->name('vehicle.activate');

Route::post('/vehicles/findDateFieldWithDocTypeID/','VehicleController@findDateFieldWithDocTypeID')->name('vehicles.findDateFieldWithDocTypeID');
// Route::post('/vehicles/save_doc','VehicleController@saveDocuments')->name('vehicles.doc.p');
// Route::get('/vehicle-doc/{id}/edit','VehicleController@vehicleDocumentEdit')->name('vehicle-doc.edit');
// Route::post('/vehicle-doc/{id}/edit','VehicleController@vehicleDocumentUpdate')->name('vehicle-doc.update.p');


Route::get('/vehicles/{id}/ota','VehicleController@vehicleOta')->name('vehicle.ota');
Route::post('/vehicle/{id}/ota-update','VehicleController@updateOta')->name('vehicles.ota.update.p');


Route::get('/vehicles/{id}/playback','VehicleController@playbackHMap')->name('vehicles.playback');

Route::post('/vehicles/location-playback','VehicleController@hmapLocationPlayback')->name('vehicles.location-playback');

Route::get('/vehicle-driver-log','VehicleController@vehicleDriverLogList')->name('vehicle-driver-log');

Route::post('/vehicle-driver-log-list','VehicleController@getVehicleDriverLogList')->name('vehicle-driver-log-list');

Route::get('/all-vehicle-docs','VehicleController@allVehicleDocList')->name('all-vehicle-docs');

Route::post('/all-vehicle-docs-list','VehicleController@getAllVehicleDocList')->name('all-vehicle-docs-list');







//////////////////////////////////Route in vehicle//////////////////////////////

Route::post('/vehicle-route/save_route','VehicleController@saveVehicleRoute')->name('vehicle-route.create.p');
Route::get('/vehicle-route/{id}/edit','VehicleController@editVehicleRoute')->name('vehicle-route.edit');
Route::post('/vehicle-route/{id}/edit','VehicleController@updateVehicleRoute')->name('vehicle-route.update.p');
Route::get('/vehicle-route/{id}/view','VehicleController@viewVehicleRoute')->name('vehicle-route.view');
Route::get('vehicle-route/{id}/delete','VehicleController@deleteVehicleRoute')->name('vehicle-route.delete');
///////////////////////////////////invoice////////////////////////////////////////////////////////////
Route::get('/invoice','VehicleController@invoice')->name('invoice');

Route::post('/vehicle-invoice/export','VehicleController@export')->name('vehicle-invoice.export.p');




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
Route::group(['middleware' => ['web','auth','role:root|dealer|sub_dealer|client|school'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {

Route::get('/vehicles/{id}/location','VehicleController@location')->name('vehicles.location');

Route::post('/vehicles/location-track','VehicleController@locationTrack')->name('vehicles.location-track');


});

//////////////////////////////////////////////////////////////////////////////////

Route::group(['middleware' => ['web','auth','role:servicer'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {
Route::get('/servicer/vehicles/{id}/create','VehicleController@servicerCreateVehicle')->name('servicer.vehicles.create');
Route::post('/servicer-vehicle-list','VehicleController@servicerVehicleList')->name('servicer-vehicle-list');
Route::get('/servicer-vehicles/create','VehicleController@createVehicle')->name('servicer.vehicles.create');
Route::get('/servicer-vehicle','VehicleController@servicerVehicleList')->name('servicer-vehicle');

Route::post('/servicer-vehicle-list','VehicleController@getServicerVehicleList')->name('servicer.vehicle-list');

});
Route::group(['middleware' => ['web','auth','role:servicer|client|school'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {
Route::get('/servicer-vehicles/{id}/details','VehicleController@servicerVehicleDetails')->name('servicer-vehicles.details');


Route::post('/servicer-vehicles/findDateFieldWithDocTypeID/','VehicleController@servicerfindDateFieldWithDocTypeID')->name('servicer.vehicles.findDateFieldWithDocTypeID');
Route::get('vehicle-doc/{id}/delete','VehicleController@vehicleDocumentDelete')->name('vehicle-doc.delete');
Route::post('/vehicles/save_doc','VehicleController@saveDocuments')->name('vehicles.doc.p');
Route::get('/vehicle-doc/{id}/edit','VehicleController@vehicleDocumentEdit')->name('vehicle-doc.edit');
Route::post('/vehicle-doc/{id}/edit','VehicleController@vehicleDocumentUpdate')->name('vehicle-doc.update.p');
Route::post('/vehicle/{id}/edit','VehicleController@update')->name('vehicles.update.p');


	});

Route::group(['middleware' => ['web'] ,'namespace' => 'App\Modules\Vehicle\Controllers' ] , function () {
  // new playback
  Route::get('/vehicle_playback','VehicleController@playbackPage')->name('vehicle_playback');
  Route::post('/vehicle_playback_data','VehicleController@playbackPageData')->name('vehicle_playback_data');

});
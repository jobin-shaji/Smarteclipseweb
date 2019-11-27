<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Operations\Controllers' ] , function() {
// //for dealers
Route::get('/operations','OperationsController@operationsListPage')->name('operations');
Route::post('/operations-list','OperationsController@getOperations')->name('operations-list');
Route::get('/operations/create','OperationsController@create')->name('operations.create');
Route::post('/operations/create','OperationsController@save')->name('operations.create.p');

Route::get('/operations/{id}/edit','OperationsController@edit')->name('operations.edit');
Route::post('/operations/{id}/edit','OperationsController@update')->name('operations.update.p'); 
Route::get('/operations/{id}/details','OperationsController@details')->name('operations.details');
Route::post('/operations/delete','OperationsController@deleteDealer')->name('operations.delete');
Route::post('/operations/activate','OperationsController@activateDealer')->name('dealer.activate');
Route::post('/operations/disable','OperationsController@disableOperations')->name('operations.disable');
Route::post('/operations/enable','OperationsController@enableDealer')->name('operations.enable');




});


	Route::group(['middleware' => ['web','auth','role:root|operations'] , 'namespace' => 'App\Modules\Operations\Controllers' ] , function() {

	Route::get('/operations/{id}/change-password','OperationsController@changePassword')->name('operations.change-password');
	Route::post('/operations/{id}/update-password','OperationsController@updatePassword')->name('operations.update-password.p'); 

	Route::get('/operations/profile','OperationsController@operationsProfile')->name('operations.profile');
	Route::get('/operations/profile-edit','OperationsController@editOperationsProfile')->name('operations.profile.edit');
	Route::post('/operations/{id}/profile/edit','OperationsController@updateOperationsProfile')->name('operations.profile.update.p'); 

	

	Route::get('/vehicle-make-create','VehicleMakeController@create')->name('vehicle.make.create');
	Route::post('/vehicle-make-create','VehicleMakeController@save')->name('vehicle.make.create.p');

	Route::get('/vehicle-make','VehicleMakeController@vehicleMakeListPage')->name('vehicle.make');
	Route::post('/vehicle-make-list','VehicleMakeController@getVehicleMake')->name('vehicle-make-list');

	Route::get('/vehicle-make/{id}/edit','VehicleMakeController@edit')->name('vehicle.make.edit');
	Route::post('/vehicle-make/{id}/edit','VehicleMakeController@update')->name('vehicle.make.update.p');

	Route::post('/vehicle-make/disable','VehicleMakeController@disableVheicleMake')->name('vehicle-make.disable');
	Route::post('/vehicle-make/enable','VehicleMakeController@enableVheicleMake')->name('vehicle-make.enable'); 

//////////////////////////Vehicle model//////////////////////////////


	Route::get('/vehicle-models-create','OperationsController@vehicleModelsCreate')->name('vehicle.models.create');
Route::post('/vehicle-models-create','OperationsController@vehicleModelsSave')->name('vehicle.models.create.p');

Route::get('/vehicle-models','OperationsController@vehicleModelsListPage')->name('vehicle.models');
Route::post('/vehicle-models-list','OperationsController@getVehicleModels')->name('vehicle-models-list');

Route::get('/vehicle-models/{id}/edit','OperationsController@modelEdit')->name('vehicle.models.edit');
	Route::post('/vehicle-models/{id}/edit','OperationsController@modelUpdate')->name('vehicle.models.update.p');

	Route::post('/vehicle-model/disable','OperationsController@disableVehicleModels')->name('vehicle-model.disable');
	Route::post('/vehicle-model/enable','OperationsController@enableVehicleModels')->name('vehicle-model.enable'); 
});


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


	Route::get('/vehicle-models-create','OperationsController@vehicleModelsCreate')->name('vehicle.models.create');
Route::post('/vehicle-models-create','OperationsController@vehicleModelsSave')->name('vehicle.models.create.p');
});


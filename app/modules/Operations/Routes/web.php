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

// Route::group(['middleware' => ['web','auth','role:dealer'] , 'namespace' => 'App\Modules\Dealer\Controllers' ] , function() {
// 	Route::get('/dealer/profile','DealerController@dealerProfile')->name('dealer.profile');
// 	Route::get('/dealers/profile-edit','DealerController@editDealerProfile')->name('dealers.profile.edit');
// 	Route::post('/dealers/{id}/profile/edit','DealerController@updateDealerProfile')->name('dealers.profile.update.p'); 
// });

Route::group(['middleware' => ['web','auth','role:root|operations'] , 'namespace' => 'App\Modules\Operations\Controllers' ] , function() {

Route::get('/operations/{id}/change-password','OperationsController@changePassword')->name('operations.change-password');
Route::post('/operations/{id}/update-password','OperationsController@updatePassword')->name('operations.update-password.p'); 

});


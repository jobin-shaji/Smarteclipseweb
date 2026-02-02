<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Sales\Controllers' ] , function() {
// //for dealers
Route::get('/salesman','SalesController@salesmanListPage')->name('salesman');
Route::post('/salesman-list','SalesController@getSalesmans')->name('salesman-list');
Route::get('/salesman/create','SalesController@create')->name('salesman.create');
Route::post('/salesman/create','SalesController@save')->name('salesman.create.p');
Route::get('/salesman/{id}/edit','SalesController@edit')->name('salesman.edit');
Route::post('/salesman/{id}/edit','SalesController@update')->name('salesman.update.p'); 
Route::get('/salesman/{id}/details','SalesController@details')->name('salesman.details');
Route::post('/salesman/disable','SalesController@disableSalesman')->name('salesman.disable');
Route::post('/salesman/enable','SalesController@enableSalesman')->name('salesman.enable');




});


	Route::group(['middleware' => ['web','auth','role:root|sales'] , 'namespace' => 'App\Modules\Sales\Controllers' ] , function() {
	Route::get('/salesman/{id}/change-password','SalesController@changePassword')->name('salesman.change-password');
	Route::post('/salesman/{id}/update-password','SalesController@updatePassword')->name('salesman.update-password.p'); 
	Route::get('/salesman/profile','SalesController@salesmanProfile')->name('salesman.profile');
	Route::get('/salesman/profile-edit','SalesController@editSalesmanProfile')->name('salesman.profile.edit');
	Route::post('/salesman/{id}/profile/edit','SalesController@updateSalesmanProfile')->name('salesman.profile.update.p'); 
});


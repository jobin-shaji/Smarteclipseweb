<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Client\Controllers' ] , function() {
	Route::get('/client','ClientController@clientListPage')->name('client');
	Route::post('/root-client-list','ClientController@getRootClient')->name('root-client-list');
	Route::post('/client/disable','ClientController@disableClient')->name('client.disable');
	Route::post('/client/enable','ClientController@enableClient')->name('client.enable');
});
Route::group(['middleware' => ['web','auth','role:dealer'] , 'namespace' => 'App\Modules\Client\Controllers' ] , function() {
	Route::get('/dealer-client','ClientController@dealerClientListPage')->name('dealer-client');
	Route::post('/dealer-client-list','ClientController@getDealerClient')->name('dealer-client-list');
});
Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Client\Controllers' ] , function() {
	Route::get('/clients','ClientController@clientList')->name('clients');
	Route::post('/client-list','ClientController@getClientlist')->name('client-list');
	Route::get('/client/create','ClientController@create')->name('client.create');
	Route::post('/client/create','ClientController@save')->name('client.create.p');
	Route::get('/client/{id}/edit','ClientController@edit')->name('client.edit');
	Route::post('/client/{id}/edit','ClientController@update')->name('client.update.p'); 
	Route::get('/client/{id}/change-password','ClientController@changePassword')->name('client.change-password');
	Route::post('/client/{id}/update-password','ClientController@updatePassword')->name('client.update-password.p'); 
	Route::get('/client/{id}/details','ClientController@details')->name('client.details');
	Route::post('/client/delete','ClientController@deleteClient')->name('client.delete');
	Route::post('/client/activate','ClientController@activateClient')->name('client.activate');
});

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Client\Controllers' ] , function() {
	Route::get('/client/profile','ClientController@userProfile')->name('client.profile');
	Route::post('/client/{id}/profile','ClientController@saveUserLogo')->name('client.profile.p'); 
	Route::get('/client/{id}/change-password','ClientController@changePassword')->name('client.change-password');
	Route::post('/client/{id}/update-password','ClientController@updatePassword')->name('client.update-password.p'); 

	Route::post('/client-location','ClientController@clientLocation')->name('client.location'); 
});


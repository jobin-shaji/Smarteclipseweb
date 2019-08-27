<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Client\Controllers' ] , function() {
	Route::get('/client','ClientController@clientListPage')->name('client');
	Route::post('/root-client-list','ClientController@getRootClient')->name('root-client-list');
	Route::post('/client/disable','ClientController@disableClient')->name('client.disable');
	Route::post('/client/enable','ClientController@enableClient')->name('client.enable');
	Route::get('/client/{id}/subscription','ClientController@subscription')->name('client.subscription');
	Route::post('/client-role-create/{id}','ClientController@addUserRole')->name('client.role.create.p');
	Route::post('/client/role/delete','ClientController@deleteClientRole')->name('client.role.delete');

	Route::get('/root/client/create','ClientController@clientCreate')->name('root.client.create');
	Route::post('/select/subdealer','ClientController@selectSubdealer')->name('client.role.delete');

	Route::post('/root/client/create','ClientController@clientSave')->name('root.client.create.p');

	// Route::get('/root/client/{id}/edit','ClientController@edit')->name('client.edit');
	// Route::post('/root/client/{id}/edit','ClientController@update')->name('client.update.p'); 
	// Route::get('/root/client/{id}/change-password-subdealer','ClientController@changeClientPassword')->name('client.change-password-subdealer');
	// Route::post('/root/client/{id}/update-password-subdealer','ClientController@updateClientPassword')->name('client.update-password.subdealer'); 
	// Route::get('/root/client/{id}/details','ClientController@details')->name('client.details');

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
	
	Route::post('/client/delete','ClientController@deleteClient')->name('client.delete');
	Route::post('/client/activate','ClientController@activateClient')->name('client.activate');

	

	// Route::get('dropdownlist','ClientController@index');
	// Route::get('get-state-list','ClientController@getStateList');
	// Route::get('get-city-list','ClientController@getCityList');

	
});

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Client\Controllers' ] , function() {
	Route::get('/client/profile','ClientController@userProfile')->name('client.profile');
	Route::post('/client/{id}/profile','ClientController@saveUserLogo')->name('client.profile.p'); 
	Route::get('/client/{id}/change-password','ClientController@changePassword')->name('client.change-password');
	Route::post('/client/{id}/update-password','ClientController@updatePassword')->name('client.update-password.p'); 

	Route::post('/client-location','ClientController@clientLocation')->name('client.location'); 

	Route::get('/payments','ClientController@paymentsView')->name('client.payments');
	Route::get('/payment-status','ClientController@paymentReview')->name('client.payments.review');


	Route::get('/km-calculation','ClientController@kmCalculation')->name('km-calculation');

});

Route::group(['middleware' => ['web','auth','role:sub_dealer|root'] , 'namespace' => 'App\Modules\Client\Controllers' ] , function() {
	Route::get('/client/{id}/edit','ClientController@edit')->name('client.edit');
	Route::post('/client/{id}/edit','ClientController@update')->name('client.update.p'); 
	Route::get('/client/{id}/change-password-subdealer','ClientController@changeClientPassword')->name('client.change-password-subdealer');
	Route::post('/client/{id}/update-password-subdealer','ClientController@updateClientPassword')->name('client.update-password.subdealer'); 
	Route::get('/client/{id}/details','ClientController@details')->name('client.details');
 Route::post('/client-create/get-state-list/','ClientController@getStateList')->name('client-create.get-state-list');
	  Route::post('/client-create/get-city-list/','ClientController@getCityList')->name('client-create.get-city-list');


  




	
});

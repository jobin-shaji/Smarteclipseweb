<?php 

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Client\Controllers' ] , function() {
// //for dealers
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


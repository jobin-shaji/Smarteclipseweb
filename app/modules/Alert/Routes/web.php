<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Alert\Controllers' ] , function() {

	Route::get('/alert-type/create','AlertController@create')->name('alert-type/create');
	Route::post('/alert-type/create','AlertController@save')->name('alert.type.create.p');
	Route::get('/alert-types','AlertController@alertListPage')->name('alert-types');
	Route::post('/alert-types-list','AlertController@getAlertTypes')->name('alert-types-list');
	Route::get('/alert-type/{id}/details','AlertController@details')->name('alert.types.details');
	Route::get('/alert-type/{id}/edit','AlertController@edit')->name('alert.types.edit');
	Route::post('/alert-type/{id}/edit','AlertController@update')->name('alert.types.update.p'); 
	Route::post('/alert-type/delete','AlertController@deleteAlertType')->name('alert.type.delete');
	Route::post('/alert-type/activate','AlertController@activateAlertType')->name('alert.type.activate');

});

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Alert\Controllers' ] , function() {

	Route::get('/alert','AlertController@alerts')->name('alert');
	Route::post('/alert-list','AlertController@alertsList')->name('alert-list');
	Route::post('/alert/verify','AlertController@verifyAlert')->name('alert.verify');

	Route::get('/packet','AlertController@packet')->name('packet');
	Route::post('/packet/create','AlertController@save')->name('packet.create.p');

});

Route::group(['namespace' => 'App\Modules\Alert\Controllers' ] , function() {
		Route::get('/packet','AlertController@packet')->name('packet');
	Route::post('/packet/create','AlertController@save')->name('packet.create.p');
	
	
});

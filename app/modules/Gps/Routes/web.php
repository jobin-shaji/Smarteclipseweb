<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {
	//for Gps
	Route::get('/gps','GpsController@gpsListPage')->name('gps');
	Route::post('/gps-list','GpsController@getGps')->name('gps-list');
	Route::get('/gps/create','GpsController@create')->name('gps.create');
	Route::post('/gps/create','GpsController@save')->name('gps.create.p');
	Route::get('/gps/{id}/details','GpsController@details')->name('gps.details');
	Route::get('/gps/{id}/edit','GpsController@edit')->name('gps.edit');
	Route::post('/gps/{id}/edit','GpsController@update')->name('gps.update.p'); 
	Route::post('/gps/delete','GpsController@deleteGps')->name('gps.delete');
	Route::post('/gps/activate','GpsController@activateGps')->name('gps.activate');

	//fro Gps transfer
	Route::get('/gps-transfers','GpsController@getList')->name('gps-transfers');
	Route::post('/gps-transfer-list','GpsController@getListData')->name('gps-transfer-list.p');
	Route::get('/gps-transfer/create','GpsController@createGpsTransfer')->name('gps-transfer.create');
	Route::post('/gps-transfer/save-transfer','GpsController@saveGpsTransfer')->name('gps-transfer.create.p');
	Route::post('/gps-transfer/user-detils','GpsController@userData')->name('gps-transfer.user-detils');

});

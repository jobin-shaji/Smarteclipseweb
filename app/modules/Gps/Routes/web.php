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
	Route::get('/gps/{id}/data','GpsController@data')->name('gps.data');
	Route::post('/gps-data-list','GpsController@getGpsData')->name('gps-data-list');
	Route::post('/gps-data-count','GpsController@gpsDataCount')->name('gps.data.count');


});

Route::group(['middleware' => ['web','auth','role:dealer'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

	//gps dealer list
	Route::get('/gps-dealer','GpsController@gpsDealerListPage')->name('gps-dealer');
	Route::post('/gps-dealer-list','GpsController@getDealerGps')->name('gps-dealer-list');
});

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

	//gps dealer list
	Route::get('/gps-sub-dealer','GpsController@gpsSubDealerListPage')->name('gps-sub-dealer');
	Route::post('/gps-sub-dealer-list','GpsController@getSubDealerGps')->name('gps-sub-dealer-list');
});

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

	//gps client list
	Route::get('/gps-client','GpsController@gpsClientListPage')->name('gps-client');
	Route::post('/gps-client-list','GpsController@getClientGps')->name('gps-client-list');
});

Route::group(['middleware' => ['web','auth','role:root|dealer|sub_dealer'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

	//fro Gps transfer
	Route::get('/gps-transfers','GpsController@getList')->name('gps-transfers');
	Route::post('/gps-transfer-list','GpsController@getListData')->name('gps-transfer-list.p');
	Route::get('/gps-transfer/create','GpsController@createGpsTransfer')->name('gps-transfer.create');
	Route::post('/gps-transfer','GpsController@saveGpsTransfer')->name('gps-transfer.create.p');
	Route::post('/gps-transfer/user-detils','GpsController@userData')->name('gps-transfer.user-detils');
});


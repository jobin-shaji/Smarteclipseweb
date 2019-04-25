<?php 
Route::group(['middleware' => ['web','auth','role:depot|waybill'] , 'namespace' => 'App\Modules\Alert\Controllers' ] , function() {

	Route::get('/alerts','AlertController@alerts')->name('alerts');
	Route::post('/alert-list','AlertController@alertsList')->name('alert-list');



});


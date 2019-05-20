<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\UserAlert\Controllers' ] , function() {

	
	Route::get('/alert-type/{id}/details','AlertController@details')->name('alert.types.details');
	
});

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\UserAlert\Controllers' ] , function() {



	Route::get('/alert-manager','UserAlertController@edit')->name('alert.manager');
	Route::post('/alert-manager-create','UserAlertController@savealertManager')->name('alert.manager.create.p');
	

});


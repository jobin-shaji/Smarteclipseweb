<?php 

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Driver\Controllers' ] , function() {
	 Route::get('/drivers','DriverController@driverList')->name('drivers');
	 Route::post('/driver-list','DriverController@getDriverlist')->name('driver-list');


	Route::get('/driver/create','DriverController@create')->name('driver.create');
	Route::post('/driver/create','DriverController@save')->name('driver.create.p');
	Route::get('/driver/{id}/edit','DriverController@edit')->name('driver.edit');
	Route::post('/driver/{id}/edit','DriverController@update')->name('driver.update.p'); 

	
	Route::get('/driver/{id}/details','DriverController@details')->name('driver.details');
	Route::post('/driver/delete','DriverController@deleteDriver')->name('driver.delete');
	Route::post('/driver/activate','DriverController@activateDriver')->name('driver.activate');
});


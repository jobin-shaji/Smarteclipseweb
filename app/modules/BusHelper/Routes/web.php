<?php 

Route::group(['middleware' => ['web','auth','role:school'] , 'namespace' => 'App\Modules\BusHelper\Controllers' ] , function() {
	Route::get('/helper','HelperController@helperList')->name('helper');
	Route::post('/helper-list','HelperController@getHelperlist')->name('helper-list');
	Route::get('/helper/create','HelperController@create')->name('helper.create');
	Route::post('/helper/create','HelperController@save')->name('helper.create.p');
	Route::get('/helper/{id}/edit','HelperController@edit')->name('helper.edit');
	Route::get('/helper/{id}/details','HelperController@details')->name('helper.details');
	Route::post('/helper/{id}/edit','HelperController@update')->name('helper.update.p');
	Route::post('/helper/delete','HelperController@deleteHelper')->name('helper.delete');
	Route::post('/helper/activate','HelperController@activateHelper')->name('helper.activate');
});


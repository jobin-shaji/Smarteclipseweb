<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {

	Route::get('/create-servicer','ServicerController@create')->name('servicer.create');
	Route::post('/save-servicer','ServicerController@save')->name('servicer.save');
	Route::get('/servicers','ServicerController@list')->name('servicer.list');

	Route::get('/servicer/{id}/details','ServicerController@details')->name('servicer.details');

	Route::post('/servicer/delete','ServicerController@delete')->name('servicer.delete');
	Route::post('/servicer/activate','ServicerController@activate')->name('servicer.activate');

});


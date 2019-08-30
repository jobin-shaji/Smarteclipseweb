<?php 

Route::group(['middleware' => ['web','auth','role:school'] , 'namespace' => 'App\Modules\RouteBatch\Controllers' ] , function() {
	Route::get('/route-batch','RouteBatchController@routeBatchList')->name('route-batch');
	Route::post('/route-batch-list','RouteBatchController@getRouteBatchlist')->name('route-batch-list');
	Route::get('/route-batch/create','RouteBatchController@create')->name('route-batch.create');
	Route::post('/route-batch/create','RouteBatchController@save')->name('route-batch.create.p');
	Route::get('/route-batch/{id}/edit','RouteBatchController@edit')->name('route-batch.edit');
	Route::post('/route-batch/{id}/edit','RouteBatchController@update')->name('route-batch.update.p');
	Route::post('/route-batch/delete','RouteBatchController@deleteRouteBatch')->name('route-batch.delete');
	Route::post('/route-batch/activate','RouteBatchController@activateRouteBatch')->name('route-batch.activate');
});


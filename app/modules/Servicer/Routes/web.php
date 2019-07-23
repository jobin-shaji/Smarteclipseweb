<?php 
Route::group(['middleware' => ['web','auth','role:root|sub_dealer'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {

	Route::get('/create-servicer','ServicerController@create')->name('servicer.create');
	Route::post('/save-servicer','ServicerController@save')->name('servicer.save');
	Route::get('/servicers','ServicerController@list')->name('servicer.list');
	Route::post('/servicers-list','ServicerController@p_List')->name('servicer.list.p');
	Route::get('/servicer/{id}/details','ServicerController@details')->name('servicer.details');

	Route::get('/servicer/{id}/edit','ServicerController@edit')->name('servicer.edit');
	Route::post('/servicer/{id}/update','ServicerController@update')->name('servicer.update');

	Route::post('/servicer/delete','ServicerController@delete')->name('servicer.delete');
	Route::post('/servicer/activate','ServicerController@activate')->name('servicer.activate');

	Route::get('/assign-servicer','ServicerController@AssignServicer')->name('assign.servicer');
	Route::post('/assign-servicer-save','ServicerController@saveAssignServicer')->name('assign.servicer.save');

	Route::get('/assign-servicer-list','ServicerController@AssignServicerList')->name('assign.servicer.list');
	Route::post('/list-assign-servicer','ServicerController@getAssignServicerList')->name('list.assign.servicer');
});

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {

	Route::get('/sub-dealer-assign-servicer','ServicerController@SubDealerAssignServicer')->name('sub-dealer.assign.servicer');
	Route::post('/sub-dealer-assign-servicer-save','ServicerController@saveSubDealerAssignServicer')->name('sub-dealer.assign.servicer.save');

	Route::get('/sub-dealer-assign-servicer-list','ServicerController@SubDealerAssignServicerList')->name('sub-dealer.assign.servicer.list');
	Route::post('/sub-dealer-list-assign-servicer','ServicerController@getSubDealerAssignServicerList')->name('sub-dealer.list.assign.servicer');
	
});


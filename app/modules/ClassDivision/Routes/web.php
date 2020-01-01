<?php 

Route::group(['middleware' => ['web','auth','role:school'] , 'namespace' => 'App\Modules\ClassDivision\Controllers' ] , function() {
	Route::get('/division','DivisionController@divisionList')->name('division');
	Route::post('/division-list','DivisionController@getDivisionlist')->name('division-list');
	Route::get('/division/create','DivisionController@create')->name('division.create');
	Route::post('/division/create','DivisionController@save')->name('division.create.p');
	Route::get('/division/{id}/edit','DivisionController@edit')->name('division.edit');
	Route::post('/division/{id}/edit','DivisionController@update')->name('division.update.p');
	Route::post('/division/delete','DivisionController@deleteDivision')->name('division.delete');
	Route::post('/division/activate','DivisionController@activateDivision')->name('division.activate');
});


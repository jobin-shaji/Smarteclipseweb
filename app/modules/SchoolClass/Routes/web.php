<?php 

Route::group(['middleware' => ['web','auth','role:school'] , 'namespace' => 'App\Modules\SchoolClass\Controllers' ] , function() {
	Route::get('/class','ClassController@classList')->name('class');
	Route::post('/class-list','ClassController@getClasslist')->name('class-list');
	Route::get('/class/create','ClassController@create')->name('class.create');
	Route::post('/class/create','ClassController@save')->name('class.create.p');
	Route::get('/class/{id}/edit','ClassController@edit')->name('class.edit');
	Route::post('/class/{id}/edit','ClassController@update')->name('class.update.p');
	Route::post('/class/delete','ClassController@deleteClass')->name('class.delete');
	Route::post('/class/activate','ClassController@activateClass')->name('class.activate');
});


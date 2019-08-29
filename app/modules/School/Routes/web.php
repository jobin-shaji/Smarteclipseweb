<?php 

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\School\Controllers' ] , function() {
	Route::get('/school','SchoolController@schoolList')->name('school');
	Route::post('/school-list','SchoolController@getSchoollist')->name('school-list');
	Route::get('/school/create','SchoolController@create')->name('school.create');
	Route::post('/school/create','SchoolController@save')->name('school.create.p');
	Route::get('/school/{id}/edit','SchoolController@edit')->name('school.edit');
	Route::get('/school/{id}/details','SchoolController@details')->name('school.details');
	Route::post('/school/{id}/edit','SchoolController@update')->name('school.update.p');
	Route::post('/school/delete','SchoolController@deleteSchool')->name('school.delete');
	Route::post('/school/activate','SchoolController@activateSchool')->name('school.activate');
});


<?php 

Route::group(['middleware' => ['web','auth','role:school'] , 'namespace' => 'App\Modules\Student\Controllers' ] , function() {
	Route::get('/student','StudentController@studentList')->name('student');
	Route::post('/student-list','StudentController@getStudentlist')->name('student-list');
	Route::get('/student/create','StudentController@create')->name('student.create');
	Route::post('/student/create','StudentController@save')->name('student.create.p');
	Route::get('/student/{id}/edit','StudentController@edit')->name('student.edit');
	Route::get('/student/{id}/details','StudentController@details')->name('student.details');
	Route::post('/student/{id}/edit','StudentController@update')->name('student.update.p');
	Route::post('/student/delete','StudentController@deleteStudent')->name('student.delete');
	Route::post('/student/activate','StudentController@activateStudent')->name('student.activate');
	Route::post('/student/class-division-dropdown/','StudentController@getClassDivisionList')->name('student.class-division-dropdown');

	// students notification

	Route::get('/student-notification/create','StudentNotifiationController@create')->name('student-nitification.create');
	Route::post('/student-notification/create','StudentNotifiationController@create')->name('student-nitification.create.p');

	Route::post('/student/get-studen-from-batch','StudentNotifiationController@getStudentFromBatch')->name('student-data.batch');
	
	Route::post('/student/route-batch','StudentController@routeBatchData')->name('student.route-batch');

});


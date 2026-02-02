<?php 
Route::group(['middleware' => ['web','auth','role:operations'] , 'namespace' => 'App\Modules\CommandsCenter\Controllers' ] , function() {

	Route::get('/commands-center','CommandsCenterController@commandsCenterMainPage')->name('commands-center');
	Route::post('/commands-center-form-submit','CommandsCenterController@commandsCenterSubmission')->name('commands-center-form-submit');

});

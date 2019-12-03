<?php 

Route::group(['middleware' => ['web','auth','role:client|school'] , 'namespace' => 'App\Modules\Driver\Controllers' ] , function() {
	Route::get('/drivers','DriverController@driverList')->name('drivers');
	Route::post('/driver-list','DriverController@getDriverlist')->name('driver-list');
	Route::get('/driver/create','DriverController@create')->name('driver.create');
	Route::post('/driver/create','DriverController@save')->name('driver.create.p');
	Route::get('/driver/{id}/edit','DriverController@edit')->name('driver.edit');
	Route::post('/driver/{id}/edit','DriverController@update')->name('driver.update.p'); 
	Route::get('/driver/{id}/details','DriverController@details')->name('driver.details');
	Route::post('/driver/delete','DriverController@deleteDriver')->name('driver.delete');
	Route::post('/driver/activate','DriverController@activateDriver')->name('driver.activate');
	Route::get('/performance-score','DriverController@performanceScore')->name('performance-score');
	Route::post('/performance-score/{id}/edit','DriverController@updatePerformanceScore')->name('performance-score.update.p');
	Route::get('/performance-score-history','DriverController@performanceScoreHistory')->name('performance.score.history');
	Route::post('/performance-score-history-list','DriverController@performanceScoreHistoryList')->name('performance-score-history-list');
	Route::get('/drivers-score-page','DriverController@driverScorePage')->name('drivers-score-page');
	Route::post('/driver-score','DriverController@driverScore')->name('driver.score');
	Route::post('/driver-score-alerts','DriverController@driverScoreAlerts')->name('driver.score-alerts');
});
Route::group(['middleware' => ['web','auth','role:servicer'] , 'namespace' => 'App\Modules\Driver\Controllers' ] , function() {
	Route::post('/servicer-driver-create','DriverController@clientDriverCreate')->name('servicer.driver.create.p');
});
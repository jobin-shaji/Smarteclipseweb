<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Alert\Controllers' ] , function() {

	Route::get('/alert-type/create','AlertController@create')->name('alert-type/create');
	Route::post('/alert-type/create','AlertController@save')->name('alert.type.create.p');
	Route::get('/alert-types','AlertController@alertListPage')->name('alert-types');
	Route::post('/alert-types-list','AlertController@getAlertTypes')->name('alert-types-list');
	Route::get('/alert-type/{id}/details','AlertController@details')->name('alert.types.details');
	Route::get('/alert-type/{id}/edit','AlertController@edit')->name('alert.types.edit');
	Route::post('/alert-type/{id}/edit','AlertController@update')->name('alert.types.update.p'); 
	Route::post('/alert-type/delete','AlertController@deleteAlertType')->name('alert.type.delete');
	Route::post('/alert-type/activate','AlertController@activateAlertType')->name('alert.type.activate');
	

});

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Alert\Controllers' ] , function() {

	Route::get('/alert','AlertController@alerts')->name('alert');
	Route::post('/alert-list','AlertController@alertsList')->name('alert-list');
	Route::post('/alert/verify','AlertController@verifyAlert')->name('alert.verify');
	Route::get('/packet','AlertController@packet')->name('packet');
	Route::post('/packet/create','AlertController@save')->name('packet.create.p');
	Route::post('/alert-notification', 'AlertController@notification')->name('alert-notification');

	Route::get('/alert-demo','AlertController@alertsDemo')->name('alert.demo');
	Route::post('/alert-demo-list','AlertController@alertsDemoList')->name('alert-demo-list');
	Route::get('/vehicle/{id}/alert','AlertController@vehicleAlerts')->name('vehicle.alert');
	

	   // Route::post('/notification_alert_count', 'AlertController@notificationAlertCount')->name('notification_alert_count');
	 Route::get('/gps-alert','AlertController@gpsAlerts')->name('gps-alert');
	Route::post('/gps-alert-list','AlertController@gpsAlertList')->name('gps.alert.list');

Route::post('/gps-alert-tracker','AlertController@alertLocation')->name('gps.alert.tracker');


Route::get('/alert/{id}/mapview','AlertController@location')->name('alert.mapview');
	// Route::post('/alert/report/show','AlertReportController@alertmap')->name('alert.report.show');





});
Route::group(['middleware' => ['web','auth','role:client|root|dealer|sub_dealer|school|servicer|operations'] , 'namespace' => 'App\Modules\Alert\Controllers' ] , function() {
 Route::post('/notification_alert_count', 'AlertController@notificationAlertCount')->name('notification_alert_count');
 });

Route::group(['namespace' => 'App\Modules\Alert\Controllers' ] , function() {
		Route::get('/packet','AlertController@packet')->name('packet');
	Route::post('/packet/create','AlertController@save')->name('packet.create.p');
	
	
});

<?php 
Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Geofence\Controllers' ] , function() {

	Route::get('/fence','GeofenceController@create')->name('fence');
	Route::post('save/fence','GeofenceController@saveFence');

		Route::get('/geofence','GeofenceController@geofenceListPage')->name('geofence');
	Route::post('/geofence-list','GeofenceController@getGeofence')->name('geofence-list');
	
	Route::get('/geofence/{id}/details','GeofenceController@details')->name('geofence.details');
	Route::post('/geofence/delete','GeofenceController@deleteGeofence')->name('geofence.delete');
	Route::post('/geofence/activate','GeofenceController@activateGeofence')->name('geofence.activate');

<<<<<<< HEAD
	Route::post('/geofence/show','GeofenceController@deleteGeofence')->name('geofence.show');

	Route::get('test','GeofenceController@test')->name('geofence.test');

=======
	Route::post('/geofence/show','GeofenceController@geofenceShow')->name('geofence.show');
>>>>>>> e2ab25d160e8f88060de39616fb41edfacf8328a
});


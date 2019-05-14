<?php 
Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Geofence\Controllers' ] , function() {

	Route::get('/fence','GeofenceController@create')->name('fence');
	Route::post('save/fence','GeofenceController@saveFence');

	Route::get('/geofence','GeofenceController@geofenceListPage')->name('geofence');
	Route::post('/geofence-list','GeofenceController@getGeofence')->name('geofence-list');
	
	Route::get('/geofence/{id}/details','GeofenceController@details')->name('geofence.details');
	Route::post('/geofence/delete','GeofenceController@deleteGeofence')->name('geofence.delete');
	Route::post('/geofence/activate','GeofenceController@activateGeofence')->name('geofence.activate');

});


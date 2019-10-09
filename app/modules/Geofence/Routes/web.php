<?php 
Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Geofence\Controllers' ] , function() {

	Route::get('/fence','GeofenceController@create')->name('fence');
	Route::post('save/fence','GeofenceController@saveFence');
	Route::get('/geofence','GeofenceController@geofenceListPage')->name('geofence');
	Route::post('/geofence-list','GeofenceController@getGeofence')->name('geofence-list');	
	Route::get('/geofence/{id}/details','GeofenceController@details')->name('geofence.details');
	Route::post('/geofence/delete','GeofenceController@deleteGeofence')->name('geofence.delete');
	Route::post('/geofence/activate','GeofenceController@activateGeofence')->name('geofence.activate');
	Route::post('/geofence/show','GeofenceController@geofenceShow')->name('geofence.show');
	Route::get('/assign/geofence-vehicle','GeofenceController@assignGeofenceList')->name('assign.geofence.vehicle');
	Route::post('/assign/assign-geofence-vehicle-list','GeofenceController@getAssignGeofenceVehicleList')->name('assign-geofence-vehicle-list');
	Route::post('/already/assign-geofence','GeofenceController@alredyassigngeofenceCount')->name('already.assign.geofence');

});

Route::group(['middleware' => ['web','auth','role:school'] , 'namespace' => 'App\Modules\Geofence\Controllers' ] , function() {

	Route::get('/school/{id}/fence','GeofenceController@schoolFenceCreate')->name('school.fence');
	Route::post('save/school-fence','GeofenceController@saveSchoolFence');	

	Route::post('/school-geofence/show','GeofenceController@schoolGeofenceShow')->name('school.geofence.show');
});


<?php 
Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Geofence\Controllers' ] , function() {

	Route::get('/fence','GeofenceController@create')->name('fence');
	Route::post('save/fence','GeofenceController@saveFence');

});


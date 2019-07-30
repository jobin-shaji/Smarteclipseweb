<?php 

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Premium\Controllers' ] , function() {
	
	// geofence report 
	Route::get('/go-premium','PremiumController@premiumListPage')->name('premium');

});


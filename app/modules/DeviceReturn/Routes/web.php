<?php



Route::group(['middleware' => ['web','auth','role:servicer'] , 'namespace' => 'App\Modules\DeviceReturn\Controllers' ] , function() {	
Route::get('/devicereturn/create','DeviceReturnController@create')->name('devicereturn.create');
Route::post('/devicereturn/create','DeviceReturnController@save')->name('devicereturn.create.p');
Route::get('/devicereturn','DeviceReturnController@deviceListPage')->name('devicereturn');
Route::post('/device-return-list','DeviceReturnController@getDeviceList')->name('device.return.list');
Route::get('/device','DeviceReturnController@DeviceReturnListPage')->name('device');
});




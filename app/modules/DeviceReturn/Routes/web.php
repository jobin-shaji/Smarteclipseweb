<?php



Route::group(['middleware' => ['web','auth','role:servicer'] , 'namespace' => 'App\Modules\DeviceReturn\Controllers' ] , function() {	
Route::get('/devicereturn/create','DeviceReturnController@create')->name('devicereturn.create');
Route::post('/devicereturn/create','DeviceReturnController@save')->name('devicereturn.create.p');
Route::get('/devicereturn','DeviceReturnController@deviceListPage')->name('devicereturn');
Route::post('/device-return-list','DeviceReturnController@getDeviceList')->name('device.return.list');
Route::get('/device','DeviceReturnController@DeviceReturnListPage')->name('device');
Route::post('/select/vehicle','DeviceReturnController@selectVehicle')->name('select.vehicle.list');
Route::post('/device-return/cancel','DeviceReturnController@cancelDeviceReturn')->name('device.return.cancel');
});

Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\DeviceReturn\Controllers' ] , function() {	
    Route::get('/device-return-history-list','DeviceReturnController@deviceReturnRootHistoryList')->name('device.return.history.list');
    Route::post('/device-return-root-history-list','DeviceReturnController@getdeviceReturnRootHistoryList')->name('device.return.root.history.list');
    });



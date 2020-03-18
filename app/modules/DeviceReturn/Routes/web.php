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
    Route::get('/device-return-detail-view/{id}/view','DeviceReturnController@deviceReturnDetailView')->name('device.return.detail.view');
    Route::get('/device-return-history-list','DeviceReturnController@deviceReturnRootHistoryList')->name('device.return.history.list');
    Route::post('/device-return-root-history-list','DeviceReturnController@getdeviceReturnRootHistoryList')->name('device.return.root.history.list');
    Route::post('/device-return/accept','DeviceReturnController@acceptDeviceReturn')->name('device.return.accept');
    Route::post('/device-return/post-activity','DeviceReturnController@addNewActivity')->name('device.return.post.activity');
    Route::get('/device-return/{id}/add-to-stock','DeviceReturnController@addToStockInDeviceReturn')->name('device.return.add.to.stock');
    Route::post('/device-return/proceed-to-stock','DeviceReturnController@proceedReturnedDeviceToStock')->name('device.return.proceed.to.stock.p');

});



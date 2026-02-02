<?php



Route::group(['middleware' => ['web','auth','role:servicer|operations|Production'] , 'namespace' => 'App\Modules\DeviceReturn\Controllers' ] , function() {	
    Route::get('/devicereturn/create','DeviceReturnController@create')->name('devicereturn.create');
    Route::post('/devicereturn/create','DeviceReturnController@save')->name('devicereturn.create.p');
    Route::get('/devicereturn','DeviceReturnController@deviceListPage')->name('devicereturn');
    Route::get('/device','DeviceReturnController@DeviceReturnListPage')->name('device');
    Route::post('/device-return-list','DeviceReturnController@getDeviceList')->name('device.return.list');
    Route::post('/select/vehicle','DeviceReturnController@selectVehicle')->name('select.vehicle.list');
    Route::post('/device-return/cancel','DeviceReturnController@cancelDeviceReturn')->name('device.return.cancel');
  
    Route::post('/devicein-send-status', 'DeviceInController@Status')->name('devicein-send-status');

    Route::get('/devicein/create','DeviceInController@create')->name('devicein.create');
    Route::post('/devicein/create','DeviceInController@save')->name('devicein.create.p');
    Route::get('/devicein','DeviceInController@deviceListPage')->name('devicein');
    Route::get('/device-service','DeviceInController@productionindex')->name('device-service');
    Route::get('/device-service-list','DeviceInController@GetIndexProduction')->name('device-service-list');
    //products details


    ///pcb in 
    

    Route::get('/pcbin','DeviceInController@pcbListPage')->name('pcbin');
    Route::get('/device-service','DeviceInController@productionindex')->name('device-service');
    Route::get('/pcb-service-list','DeviceInController@GetIndexPcb')->name('pcb-service-list');
    Route::get('/pcb-in-list','DeviceInController@getPcbList')->name('pcb.in.list');
    Route::get('view-pcb-in/{id}', 'DeviceInController@ViewPCBIN')->name('pcb.in.view');;

    Route::post('/devicein-transfer','DeviceInController@pcbTransfer')->name('devicein-transfer');
    //end pcb




    Route::get('getproduct/{id}', 'DeviceInController@getproduct')->name('getproduct');;
    Route::post('select2-products', 'DeviceInController@select2products')->name('select2-products');
    Route::post('add-products/{id}', 'DeviceInController@AddProducts')->name('add-products');


    Route::get('add-products-view/{id}', 'DeviceInController@AddProductsView')->name('add-products-view');

    Route::get('/devices','DeviceInController@DeviceReturnListPage')->name('devices');
    Route::get('/device-in-list','DeviceInController@getDeviceList')->name('device.in.list');
    Route::post('/device-in/cancel','DeviceInController@cancelDeviceReturn')->name('device.in.cancel');
    Route::get('view-device-in/{id}', 'DeviceInController@ViewServiceIn')->name('device.in.view');;


});

Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\DeviceReturn\Controllers' ] , function() {	
    Route::get('/device-return-detail-view/{id}/view','DeviceReturnController@deviceReturnDetailView')->name('device.return.detail.view');
    Route::get('/device-return-history-list','DeviceReturnController@deviceReturnRootHistoryList')->name('device.return.history.list');
    Route::post('/device-return-root-history-list','DeviceReturnController@getdeviceReturnRootHistoryList')->name('device.return.root.history.list');
    Route::post('/device-return/accept','DeviceReturnController@acceptDeviceReturn')->name('device.return.accept');
    Route::post('/device-return/post-activity','DeviceReturnController@addNewActivity')->name('device.return.post.activity');
    Route::get('/device-return/{id}/add-to-stock','DeviceReturnController@addToStockInDeviceReturn')->name('device.return.add.to.stock');
    Route::post('/device-return/proceed-to-stock','DeviceReturnController@proceedReturnedDeviceToStock')->name('device.return.proceed.to.stock.p');
    
    // Direct Device Return - for devices at dealer level
    Route::get('/direct-device-return','DeviceReturnController@directReturnPage')->name('direct-device-return');
    Route::post('/direct-device-return','DeviceReturnController@directReturnProcess')->name('direct-device-return.process');

});

Route::group(['middleware' => ['web','auth','role:root|servicer'] , 'namespace' => 'App\Modules\DeviceReturn\Controllers' ] , function() {	
    Route::get('/device-return/{id}/view','DeviceReturnController@getdeviceReturnListView')->name('device-return.view');
});



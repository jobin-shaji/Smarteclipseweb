<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Warehouse\Controllers' ] , function() {
	//for Gps
	Route::get('/gps-transfer-root','WarehouseController@createRootGpsTransfer')->name('gps.transfer.root');
	Route::post('/gps-transfer-root-dropdown','WarehouseController@getDealerDetailsFromRoot')->name('gps-transfer-root-dropdown');
	Route::post('/gps-transfer-root','WarehouseController@proceedRootGpsTransfer')->name('gps-transfer-root.transfer.p');
	Route::post('/gps-transfer-root-proceed','WarehouseController@proceedConfirmRootGpsTransfer')->name('gps-transfer-root-proceed.create.p');
	Route::get('/gps-transferred-root','WarehouseController@getRootList')->name('gps-transferred-root');
	Route::post('/gps-transferred-root/get-from-list/','WarehouseController@getFromListRoot')->name('gps-transferred-root.get-from-list');
	Route::post('/gps-transferred-root/get-to-list/','WarehouseController@getToListRoot')->name('gps-transferred-root.get-to-list');
	Route::post('/gps-transfer-list-root','WarehouseController@getRootListData')->name('gps-transfer-list-root');
	Route::post('/gps-transferred-count-root','WarehouseController@getTotalTransferredCount')->name('gps.transferred.count.root');
	Route::post('/gps-transfer-root/cancel','WarehouseController@cancelRootGpsTransfer')->name('gps.cancel-root');

	//device track in root panel
	Route::get('/gps-device-track-root','WarehouseController@getRootDeviceTrack')->name('gps.device.track.root');
	Route::post('/gps-device-track-list-root','WarehouseController@getRootDeviceTrackData')->name('gps-device-track-list.root');
	Route::get('/gps-device-track-root-details/{id}/view','WarehouseController@rootDeviceTrackDetails')->name('gps.device.track.root.details');

});
Route::group(['middleware' => ['web','auth','role:dealer'] , 'namespace' => 'App\Modules\Warehouse\Controllers' ] , function() {
	//gps new arrivals in dealer
	Route::get('/gps-dealer-new','WarehouseController@newGpsDealerListPage')->name('gps-dealer-new');
	Route::post('/gps-dealer-new-list','WarehouseController@getNewGpsDealer')->name('gps-dealer-new-list');
	Route::post('/gps-transfer-dealer/accept','WarehouseController@AcceptGpsDealerTransfer')->name('gps-dealer.accept');
	Route::post('/gps-transfer-dealer/cancel','WarehouseController@cancelDealerGpsTransfer')->name('gps-dealer.cancel');
	Route::get('/gps-transfers-dealer','WarehouseController@getDealerList')->name('gps-transfers-dealer');
	Route::post('/gps-transfer-list-dealer','WarehouseController@getDealerListData')->name('gps-transfer-list-dealer');

	//gps dealer list
	Route::get('/gps-transfer-dealer/create','WarehouseController@createDealerGpsTransfer')->name('gps-transfer-dealer.create');
	Route::post('/gps-transfer-dealer-dropdown','WarehouseController@getSubDealerDetailsFromDealer')->name('gps-transfer-dealer-dropdown');
	Route::post('/gps-transfer-dealer','WarehouseController@proceedDealerGpsTransfer')->name('gps-transfer-dealer.transfer.p');
	Route::post('/gps-transfer-dealer-proceed','WarehouseController@proceedConfirmDealerGpsTransfer')->name('gps-transfer-dealer-proceed.create.p');
});

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Warehouse\Controllers' ] , function() {

	//gps new arrivals in subdealer
	Route::get('/gps-subdealer-new','WarehouseController@newGpsSubDealerListPage')->name('gps-subdealer-new');
	Route::post('/gps-subdealer-new-list','WarehouseController@getNewGpsSubDealer')->name('gps-subdealer-new-list');
	Route::post('/gps-transfer-subdealer/accept','WarehouseController@AcceptGpsSubDealerTransfer')->name('gps-subdealer.accept');
	Route::get('/gps-transfers-subdealer','WarehouseController@getSubDealerList')->name('gps-transfers-subdealer');
	Route::post('/gps-transfer-list-subdealer','WarehouseController@getSubDealerListData')->name('gps-transfer-list-subdealer');

	//gps sub dealer list
	Route::get('/gps-transfer-sub-dealer/create','WarehouseController@createSubDealerGpsTransfer')->name('gps-transfer-sub-dealer.create');
	Route::post('/gps-transfer-sub-dealer-dropdown','WarehouseController@getClientDetailsFromSubDealer')->name('gps-transfer-sub-dealer-dropdown');
	Route::post('/gps-transfer-sub-dealer','WarehouseController@proceedSubDealerGpsTransfer')->name('gps-transfer-sub-dealer.transfer.p');
	Route::post('/gps-transfer-sub-dealer-proceed','WarehouseController@proceedConfirmSubDealerGpsTransfer')->name('gps-transfer-sub-dealer-proceed.create.p');
});

Route::group(['middleware' => ['web','auth','role:root|dealer|sub_dealer|client'] , 'namespace' => 'App\Modules\Warehouse\Controllers' ] , function() {

	//for Gps transfer
	Route::get('/gps-transfers','WarehouseController@getList')->name('gps-transfers');
	Route::post('/gps-transfer-list','WarehouseController@getListData')->name('gps-transfer-list');
	Route::get('/gps-transfer/{id}/view','WarehouseController@viewGpsTransfer')->name('gps-transfer.view');
	Route::post('/gps-transfer/user-detils','WarehouseController@userData')->name('gps-transfer.user-detils');
	Route::post('/gps-transfer/accept','WarehouseController@AcceptGpsTransfer')->name('gps.accept');
	Route::post('/gps-transfer/cancel','WarehouseController@cancelGpsTransfer')->name('gps.cancel');
	Route::get('/gps-transfer/{id}/label','WarehouseController@gpsTransferLabel')->name('gps-transfer.label');
	// Route::post('gps-transfer-label/export','WarehouseController@exportGpsTransferLabel')->name('gps-transfer-label.export');
	Route::get('/gps-transfer-label/{id}/export','WarehouseController@exportGpsTransferLabel')->name('gps-transfer-label.export');
	Route::post('/gps-scan','WarehouseController@getScannedGps')->name('gps-scan');

	//gps new arrivals in dealer
	Route::get('/gps-new','WarehouseController@newGpsListPage')->name('gps-new');
	Route::post('/gps-new-list','WarehouseController@getNewGps')->name('gps-new-list');

});


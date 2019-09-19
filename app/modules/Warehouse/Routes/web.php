<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Warehouse\Controllers' ] , function() {
//for Gps
Route::get('/gps-transferred','WarehouseController@gpsTransferredListPage')->name('gps-transferred');
Route::post('/gps-transferred-list','WarehouseController@getTransferredGps')->name('gps-transferred-list');
Route::get('/gps-transfer-root/create','WarehouseController@createRootGpsTransfer')->name('gps-transfer-root.create');
Route::post('/gps-transfer-root-dropdown','WarehouseController@getDealerDetailsFromRoot')->name('gps-transfer-root-dropdown');
Route::post('/gps-transfer-root','WarehouseController@proceedRootGpsTransfer')->name('gps-transfer-root.transfer.p');
Route::post('/gps-transfer-root-proceed','WarehouseController@proceedConfirmRootGpsTransfer')->name('gps-transfer-root-proceed.create.p');
Route::get('/gps-transfers-root','WarehouseController@getRootList')->name('gps-transfers-root');
Route::post('/gps-transfer-list-root','WarehouseController@getRootListData')->name('gps-transfer-list-root');
Route::post('/gps-transfer-root/cancel','WarehouseController@cancelRootGpsTransfer')->name('gps.cancel-root');

});
Route::group(['middleware' => ['web','auth','role:dealer'] , 'namespace' => 'App\Modules\Warehouse\Controllers' ] , function() {
//gps new arrivals in dealer
Route::get('/gps-dealer-new','WarehouseController@newGpsDealerListPage')->name('gps-dealer-new');
Route::post('/gps-dealer-new-list','WarehouseController@getNewGpsDealer')->name('gps-dealer-new-list');
Route::post('/gps-transfer-dealer/accept','WarehouseController@AcceptGpsDealerTransfer')->name('gps-dealer.accept');
Route::post('/gps-transfer-dealer/cancel','WarehouseController@cancelGpsDealerTransfer')->name('gps-dealer.cancel');

//gps dealer list
Route::get('/gps-transfer-dealer/create','WarehouseController@createDealerGpsTransfer')->name('gps-transfer-dealer.create');
Route::post('/gps-transfer-dealer-dropdown','WarehouseController@getSubDealerDetailsFromDealer')->name('gps-transfer-dealer-dropdown');
Route::post('/gps-transfer-dealer','WarehouseController@proceedDealerGpsTransfer')->name('gps-transfer-dealer.transfer.p');
Route::post('/gps-transfer-dealer-proceed','WarehouseController@proceedConfirmDealerGpsTransfer')->name('gps-transfer-dealer-proceed.create.p');
});

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Warehouse\Controllers' ] , function() {

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


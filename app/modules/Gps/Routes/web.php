<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {
//for Gps
Route::get('/gps','GpsController@gpsListPage')->name('gps');
Route::post('/gps-list','GpsController@getGps')->name('gps-list');
Route::get('/gps-transferred','GpsController@gpsTransferredListPage')->name('gps-transferred');
Route::post('/gps-transferred-list','GpsController@getTransferredGps')->name('gps-transferred-list');
Route::get('/gps/create','GpsController@create')->name('gps.create');
Route::post('/gps/create','GpsController@save')->name('gps.create.p');
Route::get('/gps/{id}/details','GpsController@details')->name('gps.details');
Route::get('/gps/{id}/edit','GpsController@edit')->name('gps.edit');
Route::post('/gps/{id}/edit','GpsController@update')->name('gps.update.p');
Route::post('/gps/delete','GpsController@deleteGps')->name('gps.delete');
Route::post('/gps/activate','GpsController@activateGps')->name('gps.activate');
Route::get('/gps/{id}/data','GpsController@data')->name('gps.data');
Route::post('/gps-data-list','GpsController@getGpsData')->name('gps-data-list');
Route::post('/gps-data-count','GpsController@gpsDataCount')->name('gps.data.count');
Route::get('/gps-transfer-root/create','GpsController@createRootGpsTransfer')->name('gps-transfer-root.create');
Route::post('/gps-transfer-root-dropdown','GpsController@getDealerDetailsFromRoot')->name('gps-transfer-root-dropdown');
Route::post('/gps-transfer-root','GpsController@proceedRootGpsTransfer')->name('gps-transfer-root.transfer.p');
Route::post('/gps-transfer-root-proceed','GpsController@proceedConfirmRootGpsTransfer')->name('gps-transfer-root-proceed.create.p');
Route::get('/gps/{id}/download','GpsController@downloadGpsDataTransfer')->name('gps.download');

});
Route::group(['middleware' => ['web','auth','role:dealer'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

//gps dealer list
Route::get('/gps-dealer','GpsController@gpsDealerListPage')->name('gps-dealer');
Route::post('/gps-dealer-list','GpsController@getDealerGps')->name('gps-dealer-list');
Route::get('/gps-transfer-dealer/create','GpsController@createDealerGpsTransfer')->name('gps-transfer-dealer.create');
Route::post('/gps-transfer-dealer-dropdown','GpsController@getSubDealerDetailsFromDealer')->name('gps-transfer-dealer-dropdown');
Route::post('/gps-transfer-dealer','GpsController@proceedDealerGpsTransfer')->name('gps-transfer-dealer.transfer.p');
Route::post('/gps-transfer-dealer-proceed','GpsController@proceedConfirmDealerGpsTransfer')->name('gps-transfer-dealer-proceed.create.p');
});

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

//gps sub dealer list
Route::get('/gps-sub-dealer','GpsController@gpsSubDealerListPage')->name('gps-sub-dealer');
Route::post('/gps-sub-dealer-list','GpsController@getSubDealerGps')->name('gps-sub-dealer-list');
Route::get('/gps-transfer-sub-dealer/create','GpsController@createSubDealerGpsTransfer')->name('gps-transfer-sub-dealer.create');
Route::post('/gps-transfer-sub-dealer-dropdown','GpsController@getClientDetailsFromSubDealer')->name('gps-transfer-sub-dealer-dropdown');
Route::post('/gps-transfer-sub-dealer','GpsController@proceedSubDealerGpsTransfer')->name('gps-transfer-sub-dealer.transfer.p');
Route::post('/gps-transfer-sub-dealer-proceed','GpsController@proceedConfirmSubDealerGpsTransfer')->name('gps-transfer-sub-dealer-proceed.create.p');

//gps activate-deactivate
Route::post('/gps-status/deactivate','GpsController@gpsStatusDeactivate')->name('gps-status.deactivate');
Route::post('/gps-status/activate','GpsController@gpsStatusActivate')->name('gps-status.activate');
//view log
Route::get('/gps/{id}/status-log','GpsController@viewStatusLog')->name('gps.status-log');
});

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

//gps client list
Route::get('/gps-client','GpsController@gpsClientListPage')->name('gps-client');
Route::post('/gps-client-list','GpsController@getClientGps')->name('gps-client-list');
});

Route::group(['middleware' => ['web','auth','role:root|dealer|sub_dealer|client'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

//for Gps transfer
Route::get('/gps-transfers','GpsController@getList')->name('gps-transfers');
Route::post('/gps-transfer-list','GpsController@getListData')->name('gps-transfer-list');
Route::get('/gps-transfer/{id}/view','GpsController@viewGpsTransfer')->name('gps-transfer.view');
Route::post('/gps-transfer/user-detils','GpsController@userData')->name('gps-transfer.user-detils');
Route::post('/gps-transfer/accept','GpsController@AcceptGpsTransfer')->name('gps.accept');
Route::post('/gps-transfer/cancel','GpsController@cancelGpsTransfer')->name('gps.cancel');
Route::get('/gps-transfer/{id}/label','GpsController@gpsTransferLabel')->name('gps-transfer.label');
// Route::post('gps-transfer-label/export','GpsController@exportGpsTransferLabel')->name('gps-transfer-label.export');
Route::get('/gps-transfer-label/{id}/export','GpsController@exportGpsTransferLabel')->name('gps-transfer-label.export');
Route::post('/gps-scan','GpsController@getScannedGps')->name('gps-scan');

//gps new arrivals in dealer
Route::get('/gps-new','GpsController@newGpsListPage')->name('gps-new');
Route::post('/gps-new-list','GpsController@getNewGps')->name('gps-new-list');
});

Route::group(['namespace' => 'App\Modules\Gps\Controllers' ] , function() {

Route::get('/gps-data','GpsController@allgpsListPage')->name('gps-data');
Route::post('/alldata-list','GpsController@getAllData')->name('alldata-list');

Route::get('/vltdata','GpsController@vltdataListPage')->name('vlt-data');

Route::get('/test','GpsController@testKm')->name('testkm');

Route::post('/vltdata-list','GpsController@getVltData')->name('vltdata-list');

Route::post('/get-gps-data','GpsController@getGpsAllData')->name('get-gps-data');


});
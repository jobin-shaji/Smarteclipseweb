<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Sos\Controllers' ] , function() {
//for Sos
Route::get('/sos','SosController@sosListPage')->name('sos');
Route::post('/sos-list','SosController@getsos')->name('sos-list');
Route::get('/sos-transferred','SosController@sosTransferredListPage')->name('sos-transferred');
Route::post('/sos-transferred-list','SosController@getTransferredSos')->name('sos-transferred-list');
Route::get('/sos/create','SosController@create')->name('sos.create');
Route::post('/sos/create','SosController@save')->name('sos.create.p');
Route::get('/sos/{id}/details','SosController@details')->name('sos.details');
Route::get('/sos/{id}/edit','SosController@edit')->name('sos.edit');
Route::post('/sos/{id}/edit','SosController@update')->name('sos.update.p');
Route::post('/sos/delete','SosController@deleteSos')->name('sos.delete');
Route::post('/sos/activate','SosController@activateSos')->name('sos.activate');
Route::get('/sos-transfer-root/create','SosController@createRootSosTransfer')->name('sos-transfer-root.create');
Route::post('/sos-transfer-root-dropdown','SosController@getDealerDetailsFromRoot')->name('sos-transfer-root-dropdown');
Route::post('/sos-transfer-root','SosController@proceedRootSosTransfer')->name('sos-transfer-root.transfer.p');
Route::post('/sos-transfer-root-proceed','SosController@proceedConfirmRootSosTransfer')->name('sos-transfer-root-proceed.create.p');
Route::get('/sos/{id}/download','SosController@downloadSosDataTransfer')->name('sos.download');

});

Route::group(['middleware' => ['web','auth','role:dealer'] , 'namespace' => 'App\Modules\Sos\Controllers' ] , function() {

//sos dealer list
Route::get('/sos-dealer','SosController@sosDealerListPage')->name('sos-dealer');
Route::post('/sos-dealer-list','SosController@getDealerSos')->name('sos-dealer-list');
Route::get('/sos-transfer-dealer/create','SosController@createDealerSosTransfer')->name('sos-transfer-dealer.create');
Route::post('/sos-transfer-dealer-dropdown','SosController@getSubDealerDetailsFromDealer')->name('sos-transfer-dealer-dropdown');
Route::post('/sos-transfer-dealer','SosController@proceedDealerSosTransfer')->name('sos-transfer-dealer.transfer.p');
Route::post('/sos-transfer-dealer-proceed','SosController@proceedConfirmDealerSosTransfer')->name('sos-transfer-dealer-proceed.create.p');
});

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Sos\Controllers' ] , function() {

//sos sub dealer list
Route::get('/sos-sub-dealer','SosController@sosSubDealerListPage')->name('sos-sub-dealer');
Route::post('/sos-sub-dealer-list','SosController@getSubDealerSos')->name('sos-sub-dealer-list');
Route::get('/sos-transfer-sub-dealer/create','SosController@createSubDealerSosTransfer')->name('sos-transfer-sub-dealer.create');
Route::post('/sos-transfer-sub-dealer-dropdown','SosController@getClientDetailsFromSubDealer')->name('sos-transfer-sub-dealer-dropdown');
Route::post('/sos-transfer-sub-dealer','SosController@proceedSubDealerSosTransfer')->name('sos-transfer-sub-dealer.transfer.p');
Route::post('/sos-transfer-sub-dealer-proceed','SosController@proceedConfirmSubDealerSosTransfer')->name('sos-transfer-sub-dealer-proceed.create.p');

});

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Sos\Controllers' ] , function() {

//sos client list
Route::get('/sos-client','SosController@sosClientListPage')->name('sos-client');
Route::post('/sos-client-list','SosController@getClientSos')->name('sos-client-list');
});

Route::group(['middleware' => ['web','auth','role:root|dealer|sub_dealer|client'] , 'namespace' => 'App\Modules\Sos\Controllers' ] , function() {

//for sos transfer
Route::get('/sos-transfers','SosController@getList')->name('sos-transfers');
Route::post('/sos-transfer-list','SosController@getListData')->name('sos-transfer-list');
Route::get('/sos-transfer/{id}/view','SosController@viewSosTransfer')->name('sos-transfer.view');
Route::post('/sos-transfer/user-detils','SosController@userData')->name('sos-transfer.user-detils');
Route::post('/sos-transfer/accept','SosController@AcceptSosTransfer')->name('sos.accept');
Route::post('/sos-transfer/cancel','SosController@cancelSosTransfer')->name('sos.cancel');
Route::get('/sos-transfer/{id}/label','SosController@sosTransferLabel')->name('sos-transfer.label');
// Route::post('sos-transfer-label/export','SosController@exportSosTransferLabel')->name('sos-transfer-label.export');
Route::get('/sos-transfer-label/{id}/export','SosController@exportSosTransferLabel')->name('sos-transfer-label.export');
Route::post('/sos-scan','SosController@getScannedSos')->name('sos-scan');

//sos new arrivals in dealer
Route::get('/sos-new','SosController@newSosListPage')->name('sos-new');
Route::post('/sos-new-list','SosController@getNewSos')->name('sos-new-list');
});

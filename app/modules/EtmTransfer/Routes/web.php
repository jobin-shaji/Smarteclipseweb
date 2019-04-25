<?php 
Route::group(['middleware' => ['web','auth','role:state'] , 'namespace' => 'App\Modules\EtmTransfer\Controllers' ] , function() {

	Route::get('/etm-transfers','EtmTransferController@getList')->name('etm-transfers');

	Route::post('/etm-transfer-list','EtmTransferController@getListData')->name('etm-transfer-list.p');

	Route::get('/etm-transfer/create','EtmTransferController@createEtmTransfer')->name('etm-transfer.create');

	Route::post('/etm-transfer/depot-detils','EtmTransferController@depotData')->name('etm-transfer.depot_detils');

	Route::post('/etm-transfer/save-transfer','EtmTransferController@saveTransfer')->name('etm-transfer.create.p');

});
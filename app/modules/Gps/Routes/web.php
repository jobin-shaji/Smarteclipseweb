<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {
	//for Gps
	Route::get('/gps','GpsController@gpsListPage')->name('gps');
	Route::post('/gps-list','GpsController@getGps')->name('gps-list');
	Route::get('/gps/create','GpsController@create')->name('gps.create');
	Route::post('/gps/create','GpsController@save')->name('gps.create.p');
	Route::get('/gps/{id}/edit','GpsController@edit')->name('gps.edit');
	Route::post('/gps/{id}/edit','GpsController@update')->name('gps.update.p');
	Route::post('/gps/delete','GpsController@deleteGps')->name('gps.delete');
	Route::post('/gps/activate','GpsController@activateGps')->name('gps.activate');

	Route::get('/gps-all','GpsController@allgpsList')->name('gps.all');
	Route::post('/gps-all-list','GpsController@getAllgpsList')->name('gps.all.list');

	Route::get('/gps/{id}/location/root','GpsController@rootlocation')->name('gps.location');
	Route::post('/gps/location-track/root','GpsController@rootlocationTrack')->name('gps.location-track');
	/**location name */
	Route::post('/gps-location-name','GpsController@getAddress')->name('gps.location.name');
	/**location name */
	Route::get('/gps_playback','GpsController@playbackPage')->name('gps_playback');
	Route::get('/gps_playback_data','GpsController@playbackPageData')->name('gps_playback_data');

	Route::get('/esim-updation','GpsController@esimUpdation')->name('esim.updation');
	Route::post('/esim-upload','GpsController@saveVehicleType')->name('esim.upload');
	Route::post('/update-esim-numbers','GpsController@updateEsimNumbers')->name('update.esim.p');
	Route::post('/esim-activation-file','GpsController@EsimFileExistance')->name('esim.activation.file');
	Route::post('/compare-esim-numbers','GpsController@compareEsimNumbers')->name('compare.esim.p');

	});
	Route::group(['middleware' => ['web','auth','role:dealer'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

	//gps dealer list
	Route::get('/gps-dealer','GpsController@gpsDealerListPage')->name('gps-dealer');
	Route::post('/gps-dealer-list','GpsController@getDealerGps')->name('gps-dealer-list');


});

Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

	//gps sub dealer list
	Route::get('/gps-sub-dealer','GpsController@gpsSubDealerListPage')->name('gps-sub-dealer');
	Route::post('/gps-sub-dealer-list','GpsController@getSubDealerGps')->name('gps-sub-dealer-list');

	//gps sub dealer in stock list
	Route::get('/gps-in-stock-sub-dealer','GpsController@gpsInStockSubDealerPage')->name('gps-in-stock-sub-dealer');
	Route::post('/gps-in-stock-sub-dealer-list','GpsController@getSubDealerGpsInStock')->name('gps-in-stock-sub-dealer-list');

	//gps activate-deactivate
	Route::post('/gps-status/deactivate','GpsController@gpsStatusDeactivate')->name('gps-status.deactivate');
	Route::post('/gps-status/activate','GpsController@gpsStatusActivate')->name('gps-status.activate');
	//view log
	Route::get('/gps/{id}/status-log','GpsController@viewStatusLog')->name('gps.status-log');
});

Route::group(['middleware' => ['web','auth','role:trader'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

	//all gps list in trader 
	Route::get('/gps-trader-all-devices','GpsController@gpsTraderListPage')->name('gps-trader-all-devices');
	Route::post('/gps-trader-list','GpsController@getTraderGps')->name('gps-trader-list');

	//gps trader in stock list
	Route::get('/gps-trader-instock','GpsController@gpsInStockTraderPage')->name('gps-trader-instock');
	Route::post('/gps-trader-instock-list','GpsController@getTraderGpsInStock')->name('gps-trader-instock-list');

	//gps activate-deactivate
	Route::post('/gps-trader-status/deactivate','GpsController@gpsInTraderStatusDeactivate')->name('gps-trader-status.deactivate');
	Route::post('/gps-trader-status/activate','GpsController@gpsInTraderStatusActivate')->name('gps-trader-status.activate');
	//view log
	Route::get('/gps-trader/{id}/status-log','GpsController@viewTraderStatusLog')->name('gps.trader.status-log');
});

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

	//gps client list
	Route::get('/gps-client','GpsController@gpsClientListPage')->name('gps-client');
	Route::post('/gps-client-list','GpsController@getClientGps')->name('gps-client-list');
	Route::get('/subscription-success','GpsController@subscriptionSuccess')->name('subscription.success');
	});
	
Route::group(['middleware' => ['web','auth','role:sub_dealer|dealer|root|trader|client'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

	Route::get('/gps/{id}/details','GpsController@details')->name('gps.details');
	Route::get('/gps/{id}/download','GpsController@downloadGpsDataTransfer')->name('gps.download');

	Route::get('/returned-gps','GpsController@getReturnedGps')->name('returned-gps');
	Route::post('/returned-gps-list','GpsController@getReturnedGpsList')->name('returned-gps-list');
});

Route::group(['middleware' => ['web','auth','role:dealer|root|client|sub_dealer|trader'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {

	Route::get('/device_return_list/{id}/view','GpsController@getReturnDeviceList')->name('device.return.list');
});

Route::group(['middleware' => ['web','auth','role:operations'] ,'namespace' => 'App\Modules\Gps\Controllers' ] , function() {
	/*
	#HIDE
	Route::get('/operation-gps-data','GpsController@allgpsListPage')->name('operation-gps-data');
	Route::post('/operators-alldata-list','GpsController@getAllData')->name('operators-alldata-list');
	*/
	Route::get('/vltdata','GpsController@vltdataListPage')->name('vlt-data');
	Route::get('/test','GpsController@testKm')->name('testkm');
	Route::post('/vltdata-list','GpsController@getVltData')->name('vltdata-list');
	Route::post('/get-gps-data','GpsController@getGpsAllData')->name('get-gps-data');
	Route::post('/get-gps-data-bth','GpsController@getGpsAllDataBth')->name('get-gps-data-bth');
	Route::post('/get-gps-data-hlm','GpsController@getGpsAllDataHlm')->name('get-gps-data-hlm');

	Route::get('/privacy-policy','GpsController@privacyPolicy')->name('privacy-policy');
	/*
	#HIDE
	Route::get('/bth-data','GpsController@allBthData')->name('bth-data');
	Route::post('/allbthdata-list','GpsController@getAllBthData')->name('allbthdata-list');
	*/
	Route::get('/id/{id}/pased','GpsController@pasedData')->name('id-pased');
	// Route::post('/alldata-list','GpsController@getAllData')->name('alldata-list');
	Route::get('/gps-data-summary','GpsController@travelSummery')->name('gps-data-summery');
	Route::post('/gps.search-travel-summary','GpsController@travelSummeryData')->name('gps.search-travel-summary.p');
	/*
	#HIDE
	Route::get('/all-gps-data','GpsController@allgpsDataListPage')->name('all-gps-data');
	*/
	Route::post('/allgpsdata-list','GpsController@getAllGpsData')->name('allgpsdata-list');
	Route::post('/operations-setota','GpsController@operationsSetOtaInConsole')->name('operations-setota');

	Route::get('/ac-status','GpsController@acStatus')->name('ac-status');
	Route::get('/ota-response','GpsController@otaResponseListPage')->name('ota-response');
	Route::post('/ota-response-list','GpsController@getOtaResponseAllData')->name('ota-response-list');
	Route::get('/gps-report','GpsController@gpsReport')->name('gps-report');
	Route::post('/gps-report-list','GpsController@gpsReportList')->name('gps-report-list');

	Route::get('/combined-gps-report','GpsController@combinedGpsReport')->name('combined-gps-report');
	Route::post('/combined-gps-report-list','GpsController@combinedGpsReportList')->name('combined-gps-report-list');

	Route::get('/ota-updates','GpsController@otaUpdatesListPage')->name('ota-updates');
	Route::post('/ota-updates-list','GpsController@getOtaUpdatesAllData')->name('ota-updates-list');


	Route::get('/stock-report','GpsController@stockReport')->name('stock-report');
	Route::post('/stock-report-list','GpsController@stockReportList')->name('stock-report-list');

	Route::get('/combined-stock-report','GpsController@combinedStockReport')->name('combined-stock-report');
	Route::post('/combined-stock-report-list','GpsController@combinedReportList')->name('combined-stock-report-list');
	Route::get('/gps/stock','GpsController@createStock')->name('gps.stock');
	Route::post('/gps/stock','GpsController@saveStock')->name('gps.stock.p');

	Route::post('/gps-create-root-dropdown','GpsController@getGpsDetailsFromRoot')->name('gps-create-root-dropdown');

	Route::get('/set-ota-operations','GpsController@operationsSetOtaListPage')->name('set.ota.operations');
	Route::post('/setota-operations','GpsController@setOtaInConsoleOperations')->name('setota.operations');

	Route::post('/select-ota-params','GpsController@selectOtaParamByGps')->name('select-ota-params');
	Route::get('/device-warranty','GpsController@deviceWarranty')->name('device.warranty');
	Route::post('/add-warranty','GpsController@AddWarranty')->name('add.warranty');
	Route::get('/edit/{id}/warranty','GpsController@EditWarranty')->name('edit.warranty');
	Route::post('/update-warranty','GpsController@UpdateWarranty')->name('update.warranty');
	Route::post('/get-active-warranty','GpsController@getActiveWarranty')->name('active.warranty');
});


Route::group(['middleware' => ['web','auth','role:operations'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {
	

	Route::get('/gps-data','GpsController@allpublicgpsListPage')->name('gps-data');
	Route::post('/alldata-list','GpsController@getPublicAllData')->name('alldata-list');
	
	/*
	#HIDE
	Route::post('/get-gps-data','GpsController@getGpsAllData')->name('get-gps-data');
	*/
	/*
	#HIDE
	Route::get('/all-gps-data-public','GpsController@allPublicgpsDataListPage')->name('all-gps-data-public');
	Route::post('/allgpsdata-list-public','GpsController@getPublicAllGpsData')->name('allgpsdata-list-public');
	*/
	Route::post('/setota','GpsController@setOtaInConsole')->name('setota');
	Route::post('/get-gps-data-bth','GpsController@getGpsAllDataBth')->name('get-gps-data-bth');
	Route::post('/get-gps-data-hlm','GpsController@getGpsAllDataHlm')->name('get-gps-data-hlm');
	/*
	#HIDE
	Route::post('/alldata-list','GpsController@getPublicAllData')->name('alldata-list');
	*/
	Route::get('/public-vltdata','GpsController@publicVltdataListPage')->name('public-vlt-data');
	Route::post('/public-vltdata-list','GpsController@getPublicVltData')->name('public-vltdata-list');
	Route::post('/unprocessed-setota','GpsController@setOtaInUnprocessed')->name('unprocessed.setota');

});


//for packet
Route::group(['middleware' => ['web','auth','role:operations'] ,'namespace' => 'App\Modules\Gps\Controllers' ] , function() {
	
	Route::get('/packet-split-data','PacketSplitController@packetSplitListPage')->name('packet.split');
	Route::post('/allpacket-list','PacketSplitController@getPacketAllData')->name('allpacket.list');

	Route::get('/lgn-split-data','LgnController@lgnSplitListPage')->name('lgn.split');
	Route::post('/alllgn-list','LgnController@getLgnAllData')->name('alllgn.list');

	Route::get('/hlm-split-data','HlmController@hlmSplitListPage')->name('hlm.split');
	Route::post('/allhlm-list','HlmController@getHlmAllData')->name('allhlm.list');

	Route::get('/ful-split-data','FulController@FulListPage')->name('ful.split');
	Route::post('/allful-list','FulController@getFulAllData')->name('allful.list');

	Route::get('/ack-split-data','AckController@AckListPage')->name('ack.split');
	Route::post('/allack-list','AckController@getAckAllData')->name('allack.list');

	Route::get('/alt-split-data','AltController@AltListPage')->name('alt.split');
	Route::post('/allalt-list','AltController@getAltAllData')->name('allalt.list');

	Route::get('/crt-split-data','CrtController@CrtListPage')->name('crt.split');
	Route::post('/allcrt-list','CrtController@getCrtAllData')->name('allcrt.list');

	Route::get('/epb-split-data','EpbController@EpbListPage')->name('epb.split');
	Route::post('/allepb-list','EpbController@getEpbAllData')->name('allepb.list');

	Route::get('/batch-split-data','BatchController@batchListPage')->name('batch.split');
	Route::post('/all-batch-list','BatchController@getBatchAllData')->name('all.batch.list');
	
});


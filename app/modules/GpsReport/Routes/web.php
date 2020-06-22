<?php

Route::group(['middleware' => ['web','auth','role:root|dealer|sub_dealer|trader'] , 'namespace' => 'App\Modules\GpsReport\Controllers' ] , function() {	
    Route::get('/detailed-device-report','GpsReportController@detailedDeviceReport')->name('detailed-device-report');
    
    //GPS TRANSFER REPORT
    Route::get('/gps-transfer-report','GpsReportController@gpsTransferReport')->name('gps-transfer-report');
    Route::get('/gps-transfer-report-details','GpsReportController@gpsTransferReportDetails')->name('gps-transfer-report-details');
    Route::get('/gps-transfer-report-downloads','GpsReportController@gpsTransferReport')->name('gps-transfer-report-downloads');

    //GPS RETURN REPORT
    Route::get('/gps-returned-report','GpsReportController@gpsReturnedReport')->name('gps-returned-report');
    Route::post('/root-gps-return-chart','GpsReportController@returnedGpsManufacturedDateGraph')->name('root-gps-return-chart');
    Route::get('/gps-return-report-downloads','GpsReportController@gpsReturnedReport')->name('gps-return-report-downloads');

    //GPS STOCK REPORT
    Route::get('/gps-stock-report','GpsReportController@gpsStockReport')->name('gps-stock-report');
    Route::get('/gps-stock-report-downloads','GpsReportController@gpsStockReport')->name('gps-stock-report-downloads');

    //PLAN BASED REPORT
    Route::get('/plan-based-report','GpsReportController@planBasedReport')->name('plan-based-report');
    Route::post('/plan-based-report-chart','GpsReportController@planBasedReportGraph')->name('plan-based-report-chart');
    Route::get('/plan-based-report-downloads','GpsReportController@planBasedReport')->name('plan-based-report-downloads');

});

Route::group(['middleware' => ['web','auth','role:operations'] , 'namespace' => 'App\Modules\GpsReport\Controllers' ] , function() {	
    Route::get('/device-status-report','GpsReportController@deviceStatusReport')->name('device-status-report');

    //online reports
    Route::get('/device-online-report','GpsReportController@deviceOnlineReport')->name('device-online-report');
    Route::get('/device-online-report-downloads','GpsReportController@deviceOnlineReport')->name('device-online-report-downloads');


    //offline reports
    Route::get('/device-offline-report','GpsReportController@deviceOfflineReport')->name('device-offline-report');
    
});
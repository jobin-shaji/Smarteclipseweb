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

});
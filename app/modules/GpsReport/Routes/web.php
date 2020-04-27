<?php

Route::group(['middleware' => ['web','auth','role:root|dealer|sub_dealer|trader'] , 'namespace' => 'App\Modules\GpsReport\Controllers' ] , function() {	
    Route::get('/detailed-device-report','GpsReportController@detailedDeviceReport')->name('detailed-device-report');
    Route::get('/gps-transfer-report','GpsReportController@gpsTransferReport')->name('gps-transfer-report');
    Route::get('/gps-transfer-report-details','GpsReportController@gpsTransferReportDetails')->name('gps-transfer-report-details');
    Route::get('/gps-transfer-report-downloads','GpsReportController@gpsTransferReport')->name('gps-transfer-report-downloads');
});
<?php 

Route::group(['middleware' => ['web','auth','role:operations'] , 'namespace' => 'App\Modules\VltData\Controllers' ] , function() {
    Route::get('/unprocessed-data-list','VltDataController@unprocessedDataView')->name('unprocessed-data-list');
    Route::get('/console-data-list','VltDataController@consoleDataView')->name('console-data-list');
    Route::post('/console-data-packet-view','VltDataController@consoleDataPacketView')->name('console-data-packet-view');
    Route::post('/console-set-ota','VltDataController@setOtaInConsole')->name('console-set-ota');
    Route::post('/get-gps-id-from-imei','VltDataController@getGpsIdFromImei')->name('get-gps-id-from-imei');
});
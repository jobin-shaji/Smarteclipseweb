<?php

Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\DeviceReassign\Controllers' ] , function() {	
    Route::get('/devicereassign/create','DeviceReassignController@create')->name('devicereassign.create');
    Route::post('/device-reassign-list','DeviceReassignController@getDeviceList')->name('device.reassign.list.p');
    Route::post('/devicereassign/create','DeviceReassignController@hierarchylist')->name('devicehierarchy');
    Route::post('/get-gps-count','DeviceReassignController@getGpsCount')->name('get-gps-count');
    Route::post('/reassign-device','DeviceReassignController@reassignUpdate')->name('reassign.device');
    // Route::post('/get-vlt-count','DeviceReassignController@getVltCount')->name('get-vlt-count');

});



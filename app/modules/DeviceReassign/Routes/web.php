<?php



Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\DeviceReassign\Controllers' ] , function() {	

Route::get('/devicereassign/create','DeviceReassignController@create')->name('devicereassign.create');
Route::post('/device-reassign-list','DeviceReassignController@getDeviceList')->name('device.reassign.list.p');
Route::get('/devicehierarchy','DeviceReassignController@hierarchylist')->name('devicehierarchy');

});



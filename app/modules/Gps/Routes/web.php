<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Gps\Controllers' ] , function() {
//for Gps
Route::get('/gps','GpsController@gpsListPage')->name('gps');
Route::post('/gps-list','GpsController@getGps')->name('gps-list');
Route::get('/gps/create','GpsController@create')->name('gps.create');
Route::post('/gps/create','GpsController@save')->name('gps.create.p');
Route::get('/gps/{id}/details','GpsController@details')->name('gps.details');
Route::get('/gps/{id}/edit','GpsController@edit')->name('gps.edit');
Route::post('/gps/{id}/edit','GpsController@update')->name('gps.update.p');
Route::post('/gps/delete','GpsController@deleteGps')->name('gps.delete');
Route::post('/gps/activate','GpsController@activateGps')->name('gps.activate');
Route::get('/gps/{id}/download','GpsController@downloadGpsDataTransfer')->name('gps.download');

Route::get('/gps/{id}/location/root','GpsController@rootlocation')->name('vehicles.location');

Route::post('/gps/location-track/root','GpsController@rootlocationTrack')->name('vehicles.location-track');

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
Route::get('/subscription-success','GpsController@subscriptionSuccess')->name('subscription.success');
});

Route::group(['namespace' => 'App\Modules\Gps\Controllers' ] , function() {

Route::get('/gps-data','GpsController@allgpsListPage')->name('gps-data');
Route::post('/alldata-list','GpsController@getAllData')->name('alldata-list');

Route::get('/vltdata','GpsController@vltdataListPage')->name('vlt-data');

Route::get('/test','GpsController@testKm')->name('testkm');

Route::post('/vltdata-list','GpsController@getVltData')->name('vltdata-list');

Route::post('/get-gps-data','GpsController@getGpsAllData')->name('get-gps-data');


Route::post('/get-gps-data-bth','GpsController@getGpsAllDataBth')->name('get-gps-data-bth');


Route::get('/privacy-policy','GpsController@privacyPolicy')->name('privacy-policy');

Route::get('/bth-data','GpsController@allBthData')->name('bth-data');
Route::post('/allbthdata-list','GpsController@getAllBthData')->name('allbthdata-list');
Route::get('/id/{id}/pased','GpsController@pasedData')->name('id-pased');

// Route::post('/alldata-list','GpsController@getAllData')->name('alldata-list');


});
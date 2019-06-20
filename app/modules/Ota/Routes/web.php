<?php



Route::group(['middleware' => ['web','auth','role:root'] ,'namespace' => 'App\Modules\Ota\Controllers' ] , function () {

Route::get('/ota-type','OtaController@otaTypeList')->name('ota-type');

Route::post('/ota-type-list','OtaController@getOtaTypeList')->name('ota-type-list');
Route::get('/ota-type/create','OtaController@createOtaType')->name('ota-type.create');
Route::post('/ota-type/save_vehicle','OtaController@saveOtaType')->name('ota-type.create.p');
Route::get('/ota-type/{id}/edit','OtaController@editOtaType')->name('ota-type.edit');
Route::post('/ota-type/{id}/edit','OtaController@updateOtaType')->name('ota-type.update.p');
Route::get('/ota-type/{id}/details','OtaController@otaTypedetails')->name('ota-type.details');
Route::post('ota-type/delete','OtaController@deleteOtaType')->name('ota-type.delete');
Route::post('ota-type/activate','OtaController@activateOtaType')->name('ota-type.activate');

});





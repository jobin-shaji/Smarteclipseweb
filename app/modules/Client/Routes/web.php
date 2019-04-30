<?php

Route::group(['middleware' => ['web','auth','role:client'] ,'namespace' => 'App\Modules\User\Controllers' ] , function () {


Route::get('/clients','ClientController@subdealerList')->name('clients');
Route::post('/subdealer-list','SubDealerController@getSubDealersView')->name('subdealer-list');
Route::get('/sub-dealer/create','SubDealerController@create')->name('sub.dealer.create');
Route::post('/sub-dealer/create','SubDealerController@save')->name('sub.dealer.create.p');
Route::get('/sub-dealers/{id}/edit','SubDealerController@edit')->name('sub.dealers.edit');
Route::post('/sub-dealers/{id}/edit','SubDealerController@update')->name('sub.dealers.update.p'); 
Route::get('/sub-dealers/{id}/change-password','SubDealerController@changePassword')->name('sub.dealers.change-password');
Route::post('/sub-dealer/{id}/update-password','SubDealerController@updatePassword')->name('sub.dealer.update-password.p'); 
Route::get('/sub-dealers/{id}/details','SubDealerController@details')->name('sub.dealer.details');
Route::post('/sub-dealer/delete','SubDealerController@deleteSubDealer')->name('dealer.delete');
Route::post('/sub-dealer/activate','SubDealerController@activateSubDealer')->name('dealer.activate');

});
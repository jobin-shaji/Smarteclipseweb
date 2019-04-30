<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Dealer\Controllers' ] , function() {
// //for dealers
Route::get('/dealers','DealerController@dealerListPage')->name('dealers');
Route::post('/dealer-list','DealerController@getDealers')->name('dealer-list');
Route::get('/dealer/create','DealerController@create')->name('dealer.create');
Route::post('/dealer/create','DealerController@save')->name('dealer.create.p');
Route::get('/dealers/{id}/edit','DealerController@edit')->name('dealers.edit');
Route::post('/dealers/{id}/edit','DealerController@update')->name('dealers.update.p'); 
Route::get('/dealers/{id}/change-password','DealerController@changePassword')->name('dealers.change-password');
Route::post('/dealer/{id}/update-password','DealerController@updatePassword')->name('dealer.update-password.p'); 
Route::get('/dealers/{id}/details','DealerController@details')->name('dealers.details');
Route::post('/dealer/delete','DealerController@deleteDealer')->name('dealer.delete');
Route::post('/dealer/activate','DealerController@activateDealer')->name('dealer.activate');
});


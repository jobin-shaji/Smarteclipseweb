<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Operations\Controllers' ] , function() {
// //for dealers
// Route::get('/dealers','DealerController@dealerListPage')->name('dealers');
// Route::post('/dealer-list','DealerController@getDealers')->name('dealer-list');
Route::get('/operations/create','OperationsController@create')->name('operations.create');
Route::post('/operations/create','OperationsController@save')->name('operations.create.p');
// Route::get('/dealers/{id}/edit','DealerController@edit')->name('dealers.edit');
// Route::post('/dealers/{id}/edit','DealerController@update')->name('dealers.update.p'); 
// Route::get('/dealers/{id}/details','DealerController@details')->name('dealers.details');
// Route::post('/dealer/delete','DealerController@deleteDealer')->name('dealer.delete');
// Route::post('/dealer/activate','DealerController@activateDealer')->name('dealer.activate');
// Route::post('/dealer/disable','DealerController@disableDealer')->name('dealer.disable');
// Route::post('/dealer/enable','DealerController@enableDealer')->name('dealer.enable');
});

// Route::group(['middleware' => ['web','auth','role:dealer'] , 'namespace' => 'App\Modules\Dealer\Controllers' ] , function() {
// 	Route::get('/dealer/profile','DealerController@dealerProfile')->name('dealer.profile');
// 	Route::get('/dealers/profile-edit','DealerController@editDealerProfile')->name('dealers.profile.edit');
// 	Route::post('/dealers/{id}/profile/edit','DealerController@updateDealerProfile')->name('dealers.profile.update.p'); 
// });

// Route::group(['middleware' => ['web','auth','role:root|dealer'] , 'namespace' => 'App\Modules\Dealer\Controllers' ] , function() {

// Route::get('/dealers/{id}/change-password','DealerController@changePassword')->name('dealers.change-password');
// Route::post('/dealer/{id}/update-password','DealerController@updatePassword')->name('dealer.update-password.p'); 

// });


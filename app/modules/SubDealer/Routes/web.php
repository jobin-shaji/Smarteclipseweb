<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Dealer\Controllers' ] , function() {

	// //for dealers
	Route::get('/sub-dealers','SubDealerController@subdealerListPage')->name('sub-dealers');
	Route::post('/dealer-list','DealerController@getDealers')->name('dealer-list');


	// Route::get('/sub-dealer/create','DealerController@create')->name('sub.dealer.create');
	//  Route::post('/sub-dealer/create','DealerController@save')->name('sub.dealer.create.p');
	//  Route::get('/dealers/{id}/edit','DealerController@edit')->name('dealers.edit');
	//   Route::post('/dealers/{id}/edit','DealerController@update')->name('dealers.update.p'); 
	//  Route::get('/dealers/{id}/change-password','DealerController@changePassword')->name('dealers.change-password');
	//  Route::post('/dealer/{id}/update-password','DealerController@updatePassword')->name('dealer.update-password.p'); 

	// Route::get('/dealers/{id}/details','DealerController@details')->name('dealers.details');
		
	// Route::post('/dealer/delete','DealerController@deleteDealer')->name('dealer.delete');
	// Route::post('/dealer/activate','DealerController@activateDealer')->name('dealer.activate');


});


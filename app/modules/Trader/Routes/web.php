
<?php 

Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\SubDealer\Controllers' ] , function() {
	// //for dealers
	Route::get('/sub-dealers','SubDealerController@subdealerListPage')->name('sub-dealers');
	Route::post('/sub-dealer-list','SubDealerController@getSubDealers')->name('sub-dealer-list');
	Route::post('/sub-dealer/disable','SubDealerController@disableSubDealer')->name('sub-dealer.disable');
	Route::post('/sub-dealer/enable','SubDealerController@enableSubDealer')->name('sub-dealer.enable');
});


Route::group(['middleware' => ['web','auth','role:sub_dealer'] ,'namespace' => 'App\Modules\Trader\Controllers' ] , function () {
    //for listing
	Route::get('/trader','TraderController@traderList')->name('trader');
	Route::post('/trader-list','TraderController@getTraderList')->name('trader-list');
    //for create new sub dealer
	Route::get('/trader/create','TraderController@createTrader')->name('trader.create');
    Route::post('/trader/save','TraderController@saveTrader')->name('trader.create.p');
    //sub dealer details
    Route::get('/trader/{id}/details','TraderController@detailsTrader')->name('trader.details');
    //sub dealer updation
	Route::get('/trader/{id}/edit','TraderController@editTrader')->name('trader.edit');
    Route::post('/trader/{id}/edit','TraderController@updateTrader')->name('trader.update.p');
    //sub dealer password updation
	Route::get('/trader/{id}/change-password','TraderController@changeTraderPassword')->name('trader.change.password');
    Route::post('/trader/{id}/change-password','TraderController@updateTraderPassword')->name('trader.change.password.p');
    //sub dealer activate/deactivate
	Route::post('/trader/deactivate','TraderController@deactivateTrader')->name('trader.deactivate');
	Route::post('/trader/activate','TraderController@activateTrader')->name('trader.activate');
});
// trader root
Route::group(['middleware' => ['web','auth','role:root|trader'] , 'namespace' => 'App\Modules\Trader\Controllers' ] , function() {
    Route::get('/trader-root-list','TraderController@traderRootList')->name('trader.root.list');
    Route::post('/get-trader-root-list','TraderController@getTraderRootList')->name('get.trader.root.list');
    Route::post('/trader/disable','TraderController@disableTrader')->name('trader.disable');
    Route::post('/trader/enable','TraderController@enableTrader')->name('trader.enable');
     Route::get('/trader/profile','TraderController@traderProfile')->name('trader.profile');
});
// trader root
Route::group(['middleware' => ['web','auth','role:trader'] , 'namespace' => 'App\Modules\Trader\Controllers' ] , function() {
       Route::get('/trader/profile','TraderController@traderProfile')->name('trader.profile');
       Route::get('/trader_profile_change_password/{id}/change-password','TraderController@changeProfilePassword')->name('trader.profile.change.password');
       Route::post('/trader_profile_update_password/{id}/update-password','TraderController@updateProfilePassword')->name('trader.profile.update.password.p');
});
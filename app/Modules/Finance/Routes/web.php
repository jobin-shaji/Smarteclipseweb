<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Finance\Controllers' ] , function() {
// //for dealers
Route::get('/finance','FinanceController@financeListPage')->name('finance');
Route::post('/finance-list','FinanceController@getfinances')->name('finance-list');
Route::get('/finance/create','FinanceController@create')->name('finance.create');
Route::post('/finance/create','FinanceController@save')->name('finance.create.p');
Route::get('/finance/{id}/edit','FinanceController@edit')->name('finance.edit');
Route::post('/finance/{id}/edit','FinanceController@update')->name('finance.update.p'); 
Route::get('/finance/{id}/details','FinanceController@details')->name('finance.details');
Route::post('/finance/disable','FinanceController@disablefinance')->name('finance.disable');
Route::post('/finance/enable','FinanceController@enablefinance')->name('finance.enable');




});


	Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Finance\Controllers' ] , function() {
	Route::get('/finance/{id}/change-password','FinanceController@changePassword')->name('finance.change-password');
	Route::post('/finance/{id}/update-password','FinanceController@updatePassword')->name('finance.update-password.p'); 
	Route::get('/finance/profile','FinanceController@financeProfile')->name('finance.profile');
	Route::get('/finance/profile-edit','FinanceController@editFinanceProfile')->name('finance.profile.edit');
	Route::post('/finance/{id}/profile/edit','FinanceController@updateFinanceProfile')->name('finance.profile.update.p'); 
});


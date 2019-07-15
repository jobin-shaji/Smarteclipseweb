<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\SmsUsage\Controllers' ] , function() {
	Route::get('/sms-usage','SmsUsageController@usage')->name('sms-usage');

Route::post('/sms-usage-list','SmsUsageController@datausageList')->name('sms-usage-list');
	

});


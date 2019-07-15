<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\DataUsage\Controllers' ] , function() {
	Route::get('/data-usage','DataUsageController@usage')->name('usage');

Route::post('/data-usage-list','DataUsageController@datausageList')->name('data-usage-list');
	

});


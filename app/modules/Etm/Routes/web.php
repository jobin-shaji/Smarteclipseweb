<?php 
Route::group(['middleware' => ['web','auth','role:state'] , 'namespace' => 'App\Modules\Etm\Controllers' ] , function() {
	//for etm
	Route::get('/etms','EtmController@etmListPage')->name('etms');
	Route::post('/etm-list','EtmController@getEtms')->name('etm-list');
	Route::get('/etm/create','EtmController@create')->name('etm.create');
	Route::post('/etm/create','EtmController@save')->name('etm.create.p');
	Route::get('/etm/{id}/details','EtmController@details')->name('etm.details');
	Route::get('/etm/{id}/edit','EtmController@edit')->name('etm.edit');
	Route::post('/etm/{id}/edit','EtmController@update')->name('etm.update.p'); 
	Route::post('/etm/delete','EtmController@deleteEtm')->name('etm.delete');
	Route::post('/etm/activate','EtmController@activateEtm')->name('etm.activate');

});

Route::group(['middleware' => ['web','auth','role:depot'] , 'namespace' => 'App\Modules\Etm\Controllers' ] , function() {

	Route::get('/etm-list','EtmDepoController@etmListPage')->name('etms-depo');
	Route::post('/etm-depo-list','EtmDepoController@getEtms')->name('etm-depo-list');
});
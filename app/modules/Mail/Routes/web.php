<?php

Route::group(['namespace' => 'App\Modules\Client\Controllers' ] , function () {

	Route::post('/sendemail','ClientController@sendTestEmail')->name('send.email');

});


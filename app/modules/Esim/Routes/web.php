<?php 
Route::group(['middleware' => ['web','auth','role:root|operations'] , 'namespace' => 'App\Modules\Esim\Controllers' ] , function() {
    Route::get('/esim-activation-details','EsimController@getEsimDetails')->name('esim-activation.details');
    Route::post('/esim-activation-details-list','EsimController@getEsimDetailsList')->name('esim-activation.list');
    Route::get('/esim-activation/{id}/view','EsimController@getDetails')->name('esim-activation.view');
    Route::get('/esim-activation-details','EsimController@getEsimDetails')->name('esim-activation-search');
    Route::post('/esim-detail-encription','EsimController@esimDetailIdEncription')->name('esim-detail-encription');
    Route::get('/esim-sort-by-date','EsimController@getEsimDetails')->name('esim.sort.by.date');
    
    
});


<?php 

Route::group(['middleware' => ['web','auth','role:operations'] , 'namespace' => 'App\Modules\VltData\Controllers' ] , function() {

Route::get('/unprocessed-data-list','VltDataController@unprocessedDataView')->name('unprocessed-data-list');
// Route::post('/get-unprocessed-data','VltDataController@getUnprocessedData')->name('get-unprocessed-data');

});
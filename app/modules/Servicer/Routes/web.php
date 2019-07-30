<?php 
Route::group(['middleware' => ['web','auth','role:root|sub_dealer'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {

	Route::get('/create-servicer','ServicerController@create')->name('servicer.create');
	Route::post('/save-servicer','ServicerController@save')->name('servicer.save');
	Route::get('/servicers','ServicerController@list')->name('servicer.list');
	Route::post('/servicers-list','ServicerController@p_List')->name('servicer.list.p');
	Route::get('/servicer/{id}/details','ServicerController@details')->name('servicer.details');

	Route::get('/servicer/{id}/edit','ServicerController@edit')->name('servicer.edit');
	Route::post('/servicer/{id}/update','ServicerController@update')->name('servicer.update');

	Route::post('/servicer/delete','ServicerController@delete')->name('servicer.delete');
	Route::post('/servicer/activate','ServicerController@activate')->name('servicer.activate');

	
});
 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {

	Route::get('/assign-servicer','ServicerController@assignServicer')->name('assign.servicer');
	Route::post('/assign-servicer-save','ServicerController@saveAssignServicer')->name('assign.servicer.save');

	Route::get('/assign-servicer-list','ServicerController@assignServicerList')->name('assign.servicer.list');
	Route::post('/list-assign-servicer','ServicerController@getAssignServicerList')->name('list.assign.servicer');

});
Route::group(['middleware' => ['web','auth','role:sub_dealer'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {

	Route::get('/sub-dealer-assign-servicer','ServicerController@subDealerAssignServicer')->name('sub-dealer.assign.servicer');
	Route::post('/sub-dealer-assign-servicer-save','ServicerController@saveSubDealerAssignServicer')->name('sub-dealer.assign.servicer.save');

	Route::get('/sub-dealer-assign-servicer-list','ServicerController@subDealerAssignServicerList')->name('sub-dealer.assign.servicer.list');
	Route::post('/sub-dealer-list-assign-servicer','ServicerController@getSubDealerAssignServicerList')->name('sub-dealer.list.assign.servicer');
	
});


Route::group(['middleware' => ['web','auth','role:servicer'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {

	Route::get('/job-list','ServicerController@jobList')->name('job.list');
	Route::post('/list-jobs','ServicerController@getJobsList')->name('list.jobs');
	
	Route::get('/job/{id}/details','ServicerController@jobDetails')->name('job.details');

	Route::post('/servicer/vehicles/save_vehicle','ServicerController@servicerSaveVehicle')->name('servicer.vehicles.create.p');

	Route::post('/job-complete-save/{id}','ServicerController@servicerJobSave')->name('job.complete.save');

	Route::get('/job-complete-certificate/{id}','ServicerController@jobCompleteCertificate')->name('job-complete.certificate');

	Route::get('/job-complete/{id}/downloads','ServicerController@downloadJobCompleteCertificate')->name('job.complete.certificate.download');
	// Route::get('/job-complete/{id}/downloads/{vid}','ServicerController@downloadJobCompleteCertificate')->name('job.complete.certificate.download');


	// Route::get('/sub-dealer-assign-servicer-list','ServicerController@SubDealerAssignServicerList')->name('sub-dealer.assign.servicer.list');
	// Route::post('/sub-dealer-list-assign-servicer','ServicerController@getSubDealerAssignServicerList')->name('sub-dealer.list.assign.servicer');

	Route::get('/job-history-list','ServicerController@jobHistoryList')->name('job.history-list');
	Route::post('/list-history-jobs','ServicerController@getJobsHistoryList')->name('list.history.jobs');
	Route::get('/job-history/{id}/details','ServicerController@jobHistoryDetails')->name('job.history.details');

	Route::post('/servicer/vehicles/history','ServicerController@servicerJobHistory')->name('servicer.vehicles.history');

	
	
});


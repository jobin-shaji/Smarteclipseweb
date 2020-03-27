<?php 
Route::group(['middleware' => ['web','auth','role:root|sub_dealer|trader'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {

	Route::get('/create-servicer','ServicerController@create')->name('servicer.create');
	Route::post('/save-servicer','ServicerController@save')->name('servicer.save');
	Route::get('/servicers','ServicerController@list')->name('servicer.list');
	Route::post('/servicers-list','ServicerController@p_List')->name('servicer.list.p');
	Route::get('/servicer/{id}/details','ServicerController@details')->name('servicer.details');
    Route::get('/servicer/{id}/edit','ServicerController@edit')->name('servicer.edit');
	Route::post('/servicer/{id}/update','ServicerController@update')->name('servicer.update');
	Route::post('/servicer/delete','ServicerController@delete')->name('servicer.delete');
	Route::post('/servicer/activate','ServicerController@activate')->name('servicer.activate');
	Route::post('/servicer-client-gps', 'ServicerController@clientGpsList')->name('servicer.client.gps');
    Route::get('/servicer-job-history-list','ServicerController@servicerJobHistoryList')->name('servicer.job.history-list');
	Route::post('/servicer-list-history-jobs','ServicerController@getServicerJobsHistoryList')->name('servicer.list.history.jobs');	
	//servicer change pasword for root,dealer,subdealer
	Route::get('/servicer/{id}/password-change','ServicerController@changeServicerPassword')->name('servicer.change.password');
    Route::post('/servicer/{id}/password-updation','ServicerController@updateServicerPassword')->name('servicer.change.password.p');


});
 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {
    Route::get('/assign-servicer','ServicerController@assignServicer')->name('assign.servicer');
	Route::post('/assign-servicer-save','ServicerController@saveAssignServicer')->name('assign.servicer.save');
    Route::get('/assign-servicer-list','ServicerController@assignServicerList')->name('assign.servicer.list');
	Route::post('/list-assign-servicer','ServicerController@getAssignServicerList')->name('list.assign.servicer');

});


Route::group(['middleware' => ['web','auth','role:sub_dealer|trader'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {

	Route::get('/sub-dealer-assign-servicer','ServicerController@subDealerAssignServicer')->name('sub-dealer.assign.servicer');
	Route::post('/sub-dealer-assign-servicer-save','ServicerController@saveSubDealerAssignServicer')->name('sub-dealer.assign.servicer.save');
	Route::get('/sub-dealer-assign-servicer-list','ServicerController@subDealerAssignServicerList')->name('sub-dealer.assign.servicer.list');
	Route::post('/sub-dealer-list-assign-servicer','ServicerController@getSubDealerAssignServicerList')->name('sub-dealer.list.assign.servicer');
	
});


Route::group(['middleware' => ['web','auth','role:servicer'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {
Route::get('/job-list','ServicerController@jobList')->name('job_list');
// for on progress installation
Route::get('/on-progress-installation-job-list','ServicerController@onProgressInstallationJobList')->name('on_progress_job_list');	
Route::get('/service-job-list','ServicerController@serviceJobList')->name('new.service.job.list');
Route::get('/on-progress-service-job-list','ServicerController@onProgresserviceJobList')->name('inprogress.service.job.list');	
Route::get('/pending-job-list','ServicerController@pendingJob')->name('pending.job.list');
Route::post('/pending-job-list','ServicerController@pendingJobList')->name('pending.job.list');

Route::post('/allcheck-list','ServicerController@getchecklist')->name('allcheck.list');
	Route::post('/list-jobs','ServicerController@getJobsList')->name('list.jobs');
	Route::post('/service-list-jobs','ServicerController@getServiceJobsList')->name('service.list.jobs');

	 Route::get('/job/{id}/details','ServicerController@newInstallationJobDetails')->name('job.details');

	Route::get('/servicejob/{id}/servicedetails','ServicerController@serviceJobDetails')->name('service.job.details');

	Route::get('/servicejob/{id}/serviceedit','ServicerController@serviceJobedit')->name('service.job.details');

	Route::post('/servicer/vehicles/save_vehicle','ServicerController@servicerSaveVehicle')->name('servicer.vehicles.create.p');

	
	Route::post('/servicejob-complete-save/{id}','ServicerController@jobSave')->name('servicejob.complete.save');
	Route::post('/servicejob-complete-edit/{id}','ServicerController@jobupdate')->name('servicejob.complete.edit');
	Route::post('/get-vehicle-models', 'ServicerController@getVehicleModels')->name('get.vehicle.models');
	//for installation check list save
	Route::post('/servicer/checkbox-installation-save/{id}','ServicerController@getchecklist')->name('checkbox.installation.save.p');
     // for vehicle list save
     Route::post('/servicer/vehiclejob-complete-save/{id}','ServicerController@vehicleDataUpdated')->name('vehiclejob.complete.save');
     // //for installation command list save
	Route::post('/servicer/completedcommand-save/{id}','ServicerController@updateCommandcompleted')->name('completedcommand.save');
	// for intialising test start
    Route::post('/servicer/testsstart-save','ServicerController@startTest')->name('teststart.save.p');
     //for testcomplete

    Route::post('/servicer/finish-testcase-save/{id}','ServicerController@completeTestCase')->name('finish.testcase.save.p');
	// Route::post('/servicejob-complete-save/{id}','ServicerController@getchecklist')->name('servicejob.complete.save');


	// Route::get('/job-complete/{id}/downloads/{vid}','ServicerController@downloadJobCompleteCertificate')->name('job.complete.certificate.download');


	// Route::get('/sub-dealer-assign-servicer-list','ServicerController@SubDealerAssignServicerList')->name('sub-dealer.assign.servicer.list');
	// Route::post('/sub-dealer-list-assign-servicer','ServicerController@getSubDealerAssignServicerList')->name('sub-dealer.list.assign.servicer');
//for installation job history
	Route::get('/job-history-list','ServicerController@jobHistoryList')->name('completed.installation.job.list');
    Route::post('/list-history-jobs','ServicerController@getJobsHistoryList')->name('list.history.jobs');	
//for service job history
	Route::get('/servicerjob-history-list','ServicerController@serviceJobHistoryList')->name('completed.service.job.list');
    Route::post('/servicelist-history-jobs','ServicerController@getserviceJobsHistoryList')->name('servicelist.history.jobs');	

	Route::get('/servicer/profile','ServicerController@servicerProfile')->name('servicer.profile');
	Route::get('/servicer/{id}/change-password','ServicerController@changePassword')->name('servicer.change-password');
	Route::post('/servicer/{id}/update-password','ServicerController@updatePassword')->name('servicer.update-password.p'); 
	Route::get('/servicer-profile-edit','ServicerController@servicerProfileEdit')->name('servicer.profile.edit');
	Route::post('/servicer/profile/{id}/edit','ServicerController@profileUpdate')->name('servicer.profile.update.p');
	Route::post('/servicer-job-complete','ServicerController@jobstatuscomplete')->name('servicer.job.complete.p');

});


Route::group(['middleware' => ['web','auth','role:root|sub_dealer|servicer|trader'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {
	Route::get('/job-history/{id}/details','ServicerController@jobHistoryDetails')->name('job.history.details');
	Route::get('/servicer-job-history/{id}/details','ServicerController@serviceJobHistoryDetails')->name('servicer.job.history.details');
	Route::post('/servicer/vehicles/history','ServicerController@servicerJobHistory')->name('servicer.vehicles.history');
    Route::get('/job-complete-certificate/{id}','ServicerController@jobCompleteCertificate')->name('job-complete.certificate');
	Route::get('/job-complete/{id}/downloads','ServicerController@downloadJobCompleteCertificate')->name('job.complete.certificate.download');
});

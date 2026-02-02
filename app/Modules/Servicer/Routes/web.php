<?php 
Route::group(['middleware' => ['web','auth','role:root|sub_dealer|trader|servicer|operations'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {
 
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
  Route::get('/servicer-job-history-list','ServicerController@servicerJobHistoryList')->name('servicerjob.history.list');
	Route::post('/servicer-list-history-jobs','ServicerController@getServicerJobsHistoryList')->name('servicer.list.history.jobs');	
	//servicer change pasword for root,dealer,subdealer
	Route::get('/servicer/{id}/password-change','ServicerController@changeServicerPassword')->name('servicer.change.password');
	Route::post('/servicer/{id}/password-updation','ServicerController@updateServicerPassword')->name('servicer.change.password.p');
	//get client based on job type
	Route::post('/jobtype-enduser', 'ServicerController@getClientBasedOnJobType')->name('jobtype.enduser');

	Route::post('/add-delivery-details', "ServiceInController@adddeliverydetails")->name('servicer.add.delivery');

	Route::get('courierlist', "ServiceInController@courierlist")->name('courierlist');
  Route::get('getcourierlist', "ServiceInController@getcourierlist")->name('getcourierlist');
});
 
  Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {
  
  Route::get('/service-device-report','ServiceInController@ServiceDeviceReport')->name('service.device.report');
  Route::get('/service-device-status-report','ServiceInController@ServiceDeviceStatusReport')->name('service.device.status.report');
	Route::get('/assign-servicer','ServicerController@assignServicer')->name('assign.servicer');
	Route::post('/assign-servicer-save','ServicerController@saveAssignServicer')->name('assign.servicer.save');
  Route::get('/assign-servicer-list','ServicerController@assignServicerList')->name('assign.servicer.list');
	Route::post('/list-assign-servicer','ServicerController@getAssignServicerList')->name('list.assign.servicer');

});


  Route::group(['middleware' => ['web','auth','role:sub_dealer|trader'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {

	Route::get('/sub-dealer-assign-servicer','ServicerController@subDealerAssignServicer')->name('sub-dealer.assign.servicer');
	Route::get('/sub-dealer-assign-servicer-after-device-transfer/{id}','ServicerController@subDealerAssignServicer')->name('sub-dealer-assign-servicer-after-device-transfer');
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
	// Route::post('/servicer/checkbox-installation-save/{id}','ServicerController@getchecklist')->name('checkbox.installation.save.p');
	Route::post('/servicer/checkbox-installation-save/{id}','ServicerController@getchecklist')->name('checkbox.installation.save.p');
 	Route::get('/servicer-installation-vehicle-details/{id}/vehicle-add','ServicerController@getVehicleAddPage')->name('serviceeng.installation.vehicle.details');

     // for vehicle list save
  Route::post('/servicer/vehiclejob-complete-save/{id}','ServicerController@vehicleDataUpdated')->name('vehiclejob.complete.save.p');

 	Route::get('/servicer-installation-vehicle-details/{id}/vehicle-add','ServicerController@getVehicleAddPage')->name('serviceeng.installation.vehicle.details');
 	Route::get('/servicer-installation-command-details/{id}/command-add','ServicerController@getCommandAddPage')->name('serviceeng.installation.command.details');
     // //for installation command list save
	Route::post('/servicer/completedcommand-save/{id}','ServicerController@updateCommandcompleted')->name('completedcommand.save');

	Route::get('/servicer-installation-devicetest-details/{id}/device-add','ServicerController@getDeviceTestAddPage')->name('serviceeng.installation.devicetest.details');
	// for intialising test start
  Route::post('/servicer/testsstart-save','ServicerController@startTest')->name('teststart.save.p');
     //for testcomplete

  Route::post('/servicer/finish-testcase-save/{id}','ServicerController@completeTestCase')->name('finish.testcase.save.p');

  Route::post('/servicer/alltest-stop','ServicerController@sosButtonStop')->name('alltest.stop');
    
  Route::post('/servicer/devicetestbutton-reset','ServicerController@sosButtonReset')->name('devicetestbutton.reset');
    

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

	Route::get('/reinstallation-job-list','ServicerController@reinstallationJobList')->name('reinstallation-job-list');
	Route::get('/on-progress-reinstallation-job-list','ServicerController@onProgressReinstallationJobList')->name('on-progress-reinstallation-job-list');
	Route::get('/reinstallation-job-history-list','ServicerController@ReinstallationJobHistoryList')->name('reinstallation-job-history-list');

});


Route::group(['middleware' => ['web','auth','role:root|sub_dealer|servicer|trader|Finance|StoreKeeper|operations'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {
	Route::get('/job-history/{id}/details','ServicerController@jobHistoryDetails')->name('job.history.details');
	Route::get('/servicer-job-history/{id}/details','ServicerController@serviceJobHistoryDetails')->name('servicer.job.history.details');
	Route::post('/servicer/vehicles/history','ServicerController@servicerJobHistory')->name('servicer.vehicles.history');
    Route::get('/job-complete-certificate/{id}','ServicerController@jobCompleteCertificate')->name('job-complete.certificate');
	Route::get('/job-complete/{id}/downloads','ServicerController@downloadJobCompleteCertificate')->name('job.complete.certificate.download');

// started new routes for servicer from vst23 site


///Components

Route::get('service-components', 'ProductController@componentList')->name('service-components');
Route::get('getallComponents', 'ProductController@getAllComponents')->name('getallComponents');
Route::get('create-components', 'ProductController@createComponents')->name('create-components');
Route::get('view-components/{id}', 'ProductController@viewComponents')->name('view-components');
Route::get('edit-components/{id}', 'ProductController@getEditComponents')->name('edit-components');;
Route::post('addComponents', 'ProductController@storeComponents')->name('addComponents');
Route::get('/products/deleteAssets/{id}', 'ProductController@deleteAssets')->name('assets-delete');

Route::get('getEditAssets/{id}', 'ProductController@getEditAssets')->name('getEditAssets');;
//Route::post('select2/products', 'ProductController@select2products')->name('select2products');;


///



///products 

Route::get('service-products', 'ProductController@index')->name('service-products');;
Route::get('getallproducts', 'ProductController@getallproducts')->name('getallproducts');;
Route::get('addproducts', 'ProductController@create')->name('addproducts');;
Route::post('addproducts', 'ProductController@store')->name('addproducts');;
Route::get('/products/delete/{id}', 'ProductController@delete')->name('product-delete');;
Route::get('getEditproduct/{id}', 'ProductController@getproduct')->name('getEditproduct');;
Route::post('select2/products', 'ProductController@select2products')->name('select2products');;

//asssets

Route::get('service-assets', 'ProductController@assetsList')->name('service-assets');
Route::get('getallAssets', 'ProductController@getallAssets')->name('getallAssets');
Route::get('addassets', 'ProductController@createAssets')->name('addassets');
Route::post('addassets', 'ProductController@storeAssets')->name('addassets');
Route::get('/products/deleteAssets/{id}', 'ProductController@deleteAssets')->name('assets-delete');;
Route::get('getEditAssets/{id}', 'ProductController@getEditAssets')->name('getEditAssets');;
Route::post('assignassets', 'ProductController@assignAssets')->name('assignassets');;


// stores

Route::get('add-new-store', 'ServiceInController@AddnewStore')->name('add-new-store');
Route::post('post-new-store', 'ServiceInController@postNewStore')->name('post-new-store');
Route::get('list-stores', 'ServiceInController@indexStores')->name('list-service-center');
Route::get('get-index-stores', 'ServiceInController@getIndexStore')->name('get-index-stores');



///

Route::get('add-service-center', 'ServiceInController@AddServiceCenter')->name('add-service-center');
Route::post('post-service-center', 'ServiceInController@postServiceCenter')->name('post-service-center');
Route::get('list-service-center', 'ServiceInController@indexseviceCenter')->name('list-service-center');
Route::get('get-index-production', 'ServiceInController@GetIndexProduction')->name('GetIndexProduction');
Route::get('index-service-in', 'ServiceInController@indexservicein')->name('index-service-in');
Route::get('get-index-service-in', 'ServiceInController@getIndexServiceIn')->name('get-index-service-in');

Route::post('get-index-service-center', 'ServiceInController@getIndexServiceCenter')->name('get-index-service-center');


Route::get('get-service-delivered', 'ServiceInController@servicedeliverd')->name('get-service-delivered');
Route::get('deliveredview', 'ServiceInController@deliveredview')->name('deliveredview');
Route::get('getdeliveryaddress/{id}', "ServiceInController@getdeliveryaddress");

Route::get('customercareview/{id}', "ServiceInController@customercareview");

Route::get('servicein/send/{status}/{id}', [ServiceInController::class, 'Status'])->name('servicein-send-status');
Route::get('cancelled-list',[ServiceInController::class,'cancelledstatus'])->name('cancelledstatus');
Route::get('add-device-in-view', 'ServiceInController@AddDeviceInView')->name('AddDeviceInView');
Route::post('add-device-in', 'ServiceInController@AddDeviceIn')->name('AddDeviceIn');
Route::get('edit-service-in-view/{id}', 'ServiceInController@EditServiceInView')->name('EditServiceInView');
Route::post('edit-device-in/{id}', 'ServiceInController@EditServiceIn')->name('EditServiceIn');
Route::get('view-device-details/{id}', 'ServiceInController@ViewServiceIn')->name('ViewServiceIn');
Route::post('select2/imeilist', 'ServiceInController@getimeilist')->name('getimeilist');
Route::get('index-production', 'ServiceInController@productionindex')->name('index-production');
Route::get('add-products-root/{id}', 'ServiceInController@AddProductsView')->name('add-products-root');
Route::post('add-products/{id}', 'ServiceInController@AddProducts')->name('AddProducts');

Route::get('servicein/{id}', 'ServiceInController@GetServiceInById')->name('GetServiceInById');
Route::get('productionview/{id}', 'ServiceInController@ProductionView')->name('ProductionView');
Route::get('set-sim-details-update/{id}', 'ServiceInController@SimDetailsUpdate')->name('SimDetailsUpdate');
 Route::get('index-customer-care', [ServiceInController::class, 'CustomerCareIndex'])->name('CustomerCareIndex');
Route::get('get-index-customer-care', [ServiceInController::class, 'GetIndexCustomerCare'])->name('GetIndexCustomerCare');
 Route::get('index-renewal-certificate', [RenewalCertificateController::class, 'RenewalIndex'])->name('RenewalIndex');
Route::get('get-index-renewal', [RenewalCertificateController::class, 'GetIndexRenewal'])->name('GetIndexRenewal');
Route::get('create-renewal-certificates-view/{id}', [RenewalCertificateController::class, 'CreateCertificateView'])->name('CreateCertificateView');
Route::post('generate-renewal-certificate/{id}', [RenewalCertificateController::class, 'GenerateCertificate'])->name('GenerateCertificate');
// Route::get('download-renewal-cert', [RenewalCertificateController::class, 'Download']);
Route::get('generate-renewal-certificate/{id}', [RenewalCertificateController::class, 'Downloadcert'])->name('Downloadcert');


Route::get('servicein/is_verified/{id}', [ServiceInController::class, 'isverified'])->name('isverified');
Route::get('view-device-detail/{id}', [ServiceInController::class, 'ViewDeviceDetail'])->name('ViewDeviceDetail');

Route::get('invoice/{id}', [ServiceInController::class, 'invoice'])->name('invoice');
Route::get('deliverynote/{id}', [ServiceInController::class, 'deliverynote'])->name('deliverynote');

//end


});
Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Servicer\Controllers' ] , function() {
Route::get('/client-job-list','ServicerController@clientJobList')->name('client.job.list');
Route::get('/client-job-list','ServicerController@clientJobList')->name('new.client.job.list');
});

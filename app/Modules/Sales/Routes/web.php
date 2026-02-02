<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Sales\Controllers' ] , function() {
// //for dealers
Route::get('/salesman','SalesController@salesmanListPage')->name('salesman');
Route::post('/salesman-list','SalesController@getSalesmans')->name('salesman-list');
Route::get('/salesman/create','SalesController@create')->name('salesman.create');
Route::post('/salesman/create','SalesController@save')->name('salesman.create.p');
Route::get('/salesman/{id}/edit','SalesController@edit')->name('salesman.edit');
Route::post('/salesman/{id}/edit','SalesController@update')->name('salesman.update.p'); 
Route::get('/salesman/{id}/details','SalesController@details')->name('salesman.details');
Route::post('/salesman/disable','SalesController@disableSalesman')->name('salesman.disable');
Route::post('/salesman/enable','SalesController@enableSalesman')->name('salesman.enable');




});

//finance list
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Sales\Controllers' ] , function() {
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

//call center

//finance list
Route::group(['middleware' => ['web','auth','role:root|sales|'] , 'namespace' => 'App\Modules\Sales\Controllers' ] , function() {
	// //for dealers
Route::get('/callcenter','CallcenterController@callcenterListPage')->name('callcenter');
Route::post('/callcenter-list','CallcenterController@getcallcenter')->name('callcenter-list');
Route::get('/callcenter/create','CallcenterController@create')->name('callcenter.create');
Route::post('/callcenter/create','CallcenterController@save')->name('callcenter.create.p');
Route::get('/callcenter/{id}/edit','CallcenterController@edit')->name('callcenter.edit');
Route::post('/callcenter/{id}/edit','CallcenterController@update')->name('callcenter.update.p'); 
Route::get('/callcenter/{id}/details','CallcenterController@details')->name('callcenter.details');
Route::post('/callcenter/disable','CallcenterController@disablefinance')->name('callcenter.disable');
Route::post('/callcenter/enable','CallcenterController@enablefinance')->name('callcenter.enable');
Route::post('/callcenter/delete','CallcenterController@deleteCallcenter')->name('callcenter.delete');
Route::get('/callcenter/{id}/change-password','CallcenterController@changePassword')->name('callcenter.change-password');
Route::post('/callcenter/{id}/update-password','CallcenterController@updatePassword')->name('callcenter.update-password.p'); 

Route::get('/esim-bulk-assign','SalesController@getAssignesim')->name('esim.bulkassign');
Route::post('/sendBulkAssign','SalesController@sendBulkAssign')->name('sales.sendBulkAssign.p');
 
Route::get('/esim-search','SalesController@getgpsSearch')->name('esim.esim-search');


});

//call center
Route::group(['middleware' => ['web','auth','role:root|Call_Center|sales'] , 'namespace' => 'App\Modules\Sales\Controllers' ] , function() {
	// //for dealers
  		Route::get('/assigned-gps','CallcenterController@getAssignedGps')->name('assigned-gps');
		Route::post('/assigned-gps-list','CallcenterController@getAssignedGpsList')->name('assigned-gps-list');

		Route::get('/gps-followup/{id}','CallcenterController@getfollowGps')->name('follow-gps');
		Route::post('/save-follow','CallcenterController@savefollowGps')->name('sales.save-follow');
		Route::get('/followups-due-today','CallcenterController@getFollowupsDueToday')->name('followups-due-today');
       
		Route::get('/callcenter-report','CallcenterController@getCallcenterReport')->name('callcenter-report');

		Route::get('/renewed-gps','CallcenterController@getRenewedGps')->name('renewed-gps');
		Route::post('/renewed-gps-list','CallcenterController@getRenewedGpsList')->name('renewed-gps-list');




});




	Route::group(['middleware' => ['web','auth','role:root|sales'] , 'namespace' => 'App\Modules\Sales\Controllers' ] , function() {
	Route::get('/salesman/{id}/change-password','SalesController@changePassword')->name('salesman.change-password');
	Route::post('/salesman/{id}/update-password','SalesController@updatePassword')->name('salesman.update-password.p'); 
	Route::get('/salesman/profile','SalesController@salesmanProfile')->name('salesman.profile');
	Route::get('/salesman/profile-edit','SalesController@editSalesmanProfile')->name('salesman.profile.edit');
	Route::post('/salesman/{id}/profile/edit','SalesController@updateSalesmanProfile')->name('salesman.profile.update.p'); 
});

// GPS Renewal Auto-Assignment Routes
Route::group(['middleware' => ['web','auth','role:root|sales|Call_Center'] , 'namespace' => 'App\Modules\Sales\Controllers' ] , function() {
	Route::post('/renewal-automation/execute', 'RenewalAutomationController@executeAutoAssignment')->name('renewal.execute');
	Route::post('/renewal-automation/check-followups', 'RenewalAutomationController@checkFollowupEscalation')->name('renewal.check-followups');
	Route::get('/renewal-automation/urgent-list', 'RenewalAutomationController@getUrgentList')->name('renewal.urgent-list');
	Route::get('/renewal-automation/stats', 'RenewalAutomationController@getStats')->name('renewal.stats');
	Route::post('/renewal-automation/manual-reassign', 'RenewalAutomationController@manualReassign')->name('renewal.manual-reassign');
	Route::get('/auto-assigned-renewals', 'RenewalAutomationController@showAssignmentsPage')->name('renewal.assignments-page');
	Route::get('/auto-assigned-renewals/list', 'RenewalAutomationController@getAssignmentsList')->name('renewal.assignments-list');
	Route::get('/gps-details/{id}', 'RenewalAutomationController@redirectToGpsDetails')->name('renewal.gps-details');
});


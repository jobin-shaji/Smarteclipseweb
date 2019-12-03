<?php

Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Complaint\Controllers' ] , function() {

Route::get('/complaint-type','ComplaintController@complaintTypeListPage')->name('complaint-type');
Route::post('/complaint-type-list','ComplaintController@getComplaintTypes')->name('complaint-type-list');
Route::get('/complaint-type/create','ComplaintController@createComplaintType')->name('complaint-type.create');
Route::post('/complaint-type/create','ComplaintController@saveComplaintType')->name('complaint-type.create.p');
Route::post('/complaint-type/delete','ComplaintController@deleteComplaintType')->name('complaint-type.delete');
Route::post('/complaint-type/activate','ComplaintController@activateComplaintType')->name('complaint-type.activate');
});

Route::group(['middleware' => ['web','auth','role:root|sub_dealer|client'] , 'namespace' => 'App\Modules\Complaint\Controllers' ] , function() {	
Route::get('/complaint','ComplaintController@complaintListPage')->name('complaint');
Route::post('/complaint-list','ComplaintController@getComplaints')->name('complaint-list');
Route::get('/complaint/{id}/view','ComplaintController@view')->name('complaint.view');

});

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Complaint\Controllers' ] , function() {

Route::get('/complaint/create','ComplaintController@create')->name('complaint.create');
Route::post('/complaint/create','ComplaintController@save')->name('complaint.create.p');
Route::post('/complaint/complaintType/','ComplaintController@findComplaintTypeWithCategory')->name('complaint.complaintType');

});

Route::group(['middleware' => ['web','auth','role:root|sub_dealer'] , 'namespace' => 'App\Modules\Complaint\Controllers' ] , function() {	
	Route::get('/assign-complaint/{id}','ComplaintController@assignComplaint')->name('assign.complaint');
	Route::post('/complaint/assign-servicer/{id}','ComplaintController@assignComplaintToServicer')->name('complaint.assign.servicer.p');

});



Route::group(['middleware' => ['web','auth','role:servicer'] , 'namespace' => 'App\Modules\Complaint\Controllers' ] , function() {

	Route::get('/complaint-list','ComplaintController@complaintList')->name('servicer.complaint.list');
	Route::post('/list-servicer-complaints','ComplaintController@getServicerComplaints')->name('list.servicer.complaints');	

	Route::get('/assign-complaint/{id}/details','ComplaintController@complaintDetails')->name('assign-complaint.details');	
	Route::post('/complaint-complete-save/{id}','ComplaintController@completeComplaintSave')->name('complaint.complete.save');

	
});

Route::group(['middleware' => ['web','auth','role:servicer|root|sub_dealer'] , 'namespace' => 'App\Modules\Complaint\Controllers' ] , function() {
	Route::get('/complaint-history-list','ComplaintController@complaintHistoryList')->name('job.history-list');
	Route::post('/list-servicer-complaints-history','ComplaintController@getComplaintsHistoryList')->name('list.servicer.complaints.history');	
});


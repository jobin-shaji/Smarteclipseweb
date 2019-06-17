<?php

Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Complaint\Controllers' ] , function() {

Route::get('/complaint-type','ComplaintController@complaintTypeListPage')->name('complaint-type');
Route::post('/complaint-type-list','ComplaintController@getComplaintTypes')->name('complaint-type-list');
Route::get('/complaint-type/create','ComplaintController@createComplaintType')->name('complaint-type.create');
Route::post('/complaint-type/create','ComplaintController@saveComplaintType')->name('complaint-type.create.p');
Route::post('/complaint-type/delete','ComplaintController@deleteComplaintType')->name('complaint-type.delete');
Route::post('/complaint-type/activate','ComplaintController@activateComplaintType')->name('complaint-type.activate');

});

Route::group(['middleware' => ['web','auth','role:client'] , 'namespace' => 'App\Modules\Complaint\Controllers' ] , function() {

Route::get('/complaint/create','ComplaintController@create')->name('complaint.create');
Route::post('/complaint/create','ComplaintController@save')->name('complaint.create.p');
Route::post('/complaint/complaintType/','ComplaintController@findComplaintTypeWithCategory')->name('complaint.complaintType');

});

Route::group(['middleware' => ['web','auth','role:root|dealer|sub_dealer|client'] , 'namespace' => 'App\Modules\Complaint\Controllers' ] , function() {
	
Route::get('/complaint','ComplaintController@complaintListPage')->name('complaint');
Route::post('/complaint-list','ComplaintController@getComplaints')->name('complaint-list');
});

Route::group(['middleware' => ['web','auth','role:root|sub_dealer'] , 'namespace' => 'App\Modules\Complaint\Controllers' ] , function() {

Route::post('complaint/solve','ComplaintController@solveComplaint')->name('complaint.solve');
Route::post('complaint/reject','ComplaintController@rejectComplaint')->name('complaint.reject');
});


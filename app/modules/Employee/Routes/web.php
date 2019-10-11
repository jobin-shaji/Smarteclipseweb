<?php 

Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Employee\Controllers' ] , function() {
	Route::get('/employee','EmployeeController@employeeList')->name('employee');
	Route::post('/employee-list','EmployeeController@getEmployeelist')->name('employee-list');
	Route::get('/employee/create','EmployeeController@createEmployee')->name('employee.create');
	Route::post('/employee/create','EmployeeController@saveEmployee')->name('employee.create.p');
	Route::get('/employee/{id}/edit','EmployeeController@editEmployee')->name('employee.edit');
	Route::get('/employee/{id}/details','EmployeeController@detailsEmployee')->name('employee.details');
	Route::post('/employee/{id}/edit','EmployeeController@updateEmployee')->name('employee.update.p');
	Route::post('/employee/delete','EmployeeController@deleteEmployee')->name('employee.delete');
	Route::post('/employee/activate','EmployeeController@activateEmployee')->name('employee.activate');
});


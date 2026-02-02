<?php

Route::group(['middleware' => ['web','auth','role:sub_dealer'] ,'namespace' => 'App\Modules\User\Controllers' ] , function () {

        Route::get('/users/create',['as' => 'users.create','uses' => 'UserController@create']);
        Route::post('/users/create',['as' => 'users.create.p','uses' => 'UserController@store']);
});

Route::group(['middleware' => ['web','auth','role:root|sub_dealer'] ,'namespace' => 'App\Modules\User\Controllers' ] , function () {

	Route::get('/users','UserController@UserListPage')->name('users');
	Route::post('/user-list','UserController@getUsers')->name('user-list');
        Route::get('/users/{id}/edit',['as' => 'users.update','uses' => 'UserController@edit']);
        Route::post('/users/{id}/edit',['as' => 'users.update.p','uses' => 'UserController@update']);
        Route::post('/users/delete',['as' => 'users.delete','uses' => 'UserController@delete']);
        Route::get('/users/{id}/details',['as' => 'users.details','uses' => 'UserController@details']);
});
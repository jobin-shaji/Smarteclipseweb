<?php 
Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Root\Controllers' ] , function() {

	Route::get('/states','RootController@statesListPage')->name('states');
	Route::post('/states-list','RootController@getStates')->name('states-list');

  Route::get('/state/{id}/details','RootController@stateDetails')->name('state.details');

  Route::post('/state/{id}/user-create','RootController@createUser')->name('root.user.create');

  Route::get('/root/{id}/change-password','RootController@changeRootPassword')->name('root.change.password');
  Route::post('/root/{id}/update-password','RootController@updateRootPassword')->name('root.update.password.p');


  });



  // Route::post('/routes/delete','RouteController@deleteRoute')->name('route.delete');


  // Route::get('/routes/{id}/edit','RouteController@edit')->name('route.edit');
  // Route::post('/routes/{id}/edit','RouteController@update')->name('route.update.p');

  // Route::get('/routes/{id}/edit-stage','RouteController@editStage')->name('route.edit-stage');

  // Route::post('/routes/{id}/add-stage','RouteController@updateStageRoute')->name('route.UpdateRouteStage.p');

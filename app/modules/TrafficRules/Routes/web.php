<?php

Route::group(['middleware' => ['web','auth','role:root'] ,'namespace' => 'App\Modules\TrafficRules\Controllers' ] , function () {

//Traffic Rules
	Route::get('/traffic-rule','TrafficRuleController@trafficRuleList')->name('traffic-rule');
	Route::post('/traffic-rule-list','TrafficRuleController@getTrafficRuleList')->name('traffic-rule-list');

	Route::get('/traffic-rule/create','TrafficRuleController@createTrafficRule')->name('traffic-rule.create');
	Route::post('/traffic-rule/save_vehicle_type','TrafficRuleController@saveTrafficRule')->name('traffic-rule.create.p');
	Route::get('/traffic-rule/{id}/details','TrafficRuleController@detailsTrafficRule')->name('traffic-rule.details');
	Route::get('/traffic-rule/{id}/edit','TrafficRuleController@editTrafficRule')->name('traffic-rule.edit');
	Route::post('/traffic-rule/{id}/edit','TrafficRuleController@updateTrafficRule')->name('traffic-rule.update.p');
	Route::post('traffic-rule/delete','TrafficRuleController@deleteTrafficRule')->name('traffic-rule.delete');
	Route::post('/traffic-rule/activate','TrafficRuleController@activateTrafficRule')->name('traffic-rule.activate');

//dependent dropdown
   Route::post('/traffic-rule/get-state-list/','TrafficRuleController@getStateList')->name('traffic-rule.get-state-list');

});


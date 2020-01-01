<?php

Route::group(['middleware' => ['web','auth','role:root'] ,'namespace' => 'App\Modules\Subscription\Controllers' ] , function () {

//Subscription
	Route::get('/subscription','SubscriptionController@subscriptionList')->name('subscription');
	Route::post('/subscription-list','SubscriptionController@getSubscriptionList')->name('subscription-list');

	Route::get('/subscription/create','SubscriptionController@createSubscription')->name('subscription.create');
	Route::post('/subscription/save','SubscriptionController@saveSubscription')->name('subscription.create.p');
	Route::get('/subscription/{id}/details','SubscriptionController@detailsSubscription')->name('subscription.details');
	Route::get('/subscription/{id}/edit','SubscriptionController@editSubscription')->name('subscription.edit');
	Route::post('/subscription/{id}/edit','SubscriptionController@updateSubscription')->name('subscription.update.p');
	Route::post('subscription/delete','SubscriptionController@deleteSubscription')->name('subscription.delete');
	Route::post('/subscription/activate','SubscriptionController@activateSubscription')->name('subscription.activate');

});


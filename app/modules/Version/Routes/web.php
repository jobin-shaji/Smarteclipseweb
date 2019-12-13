<?php

Route::group(['middleware' => ['web','auth','role:root'] , 'namespace' => 'App\Modules\Version\Controllers' ] , function() {
Route::get('/version-type/create','VersionController@createVersionType')->name('version-type.create');
Route::post('/version-type/save_version_type','VersionController@saveVersion')->name('version-type.create.p');
Route::get('/version/{id}/details','VersionController@detailsVersion')->name('version.details');

Route::get('/version-rule','VersionController@versionRuleList')->name('version.rule');
// version-rule-list
Route::post('/version-rule-list','VersionController@getVersionRuleList')->name('version-rule-list');
});





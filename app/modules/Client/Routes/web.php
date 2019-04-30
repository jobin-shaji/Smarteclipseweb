<?php

Route::group(['middleware' => ['web','auth','role:client'] ,'namespace' => 'App\Modules\User\Controllers' ] , function () {


});
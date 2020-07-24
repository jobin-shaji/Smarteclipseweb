<?php

Route::group(['middleware' => ['web','auth','role:sub_dealer'] ,'namespace' => 'App\Modules\User\Controllers' ] , function () {

       
});

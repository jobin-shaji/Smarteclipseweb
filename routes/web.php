<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  
          $url=url()->current();
          $rayfleet_key="rayfleet";
          $eclipse_key="eclipse";
          if (strpos($url, $rayfleet_key) == true) { 
              return view('welcome');
        } 
          else if (strpos($url, $eclipse_key) == true) { 
               return view('welcome1');
           }else { 
               return view('welcome1');
           }
  


});

Route::get('/privacy-policy', function () {

	$url=url()->current();
        $rayfleet_key="rayfleet";
        $eclipse_key="eclipse";
        if (strpos($url, $rayfleet_key) == true) 
         {
          return view('rayfleet-privacy-policy');
         }else{
           return view('privacy-policy');
         }
});



// routes/web.php eugene
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
// routes/web.php
/*
Route::get('/home', function () {
  return view('home');
})->name('home');
*/
//eugene end

Route::get('/download-invoice/{id}','GeneralController@generateInvoicePdf')->name('download-invoice');

Route::get('/download-cmc/{id}','GeneralController@generateCMCPdf')->name('download-cmc');

Route::get('/testmail','TestController@testMail')->name('test-mail');
Route::get('/maps','MapController@LoadMap')->name('maps');

Route::get('/logout', function(){
  Auth::logout();
  return Redirect::to('login');
});

Auth::routes();




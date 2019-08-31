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

    return view('welcome');
    //return redirect('login');

});
Route::get('/pusher', function() {
    event(new App\Events\UserListing('Hi there Pusher!'));
    return "Event has been sent!";
});


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('google', function () {
    return view('googleAuth');
});
    
Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');
Route::group(['middleware' => ['auth']], function() {
Route::get('/home', ['uses'=>'HomeController@index'])->name('home');
Route::get('/users', ['uses'=>'HomeController@userlist'])->name('userlist');
Route::get('/createComplaints', ['uses'=>'HomeController@createComplaints'])->name('createcomplaints');
Route::post('/savepost', ['uses'=>'PostController@savepost'])->name('savepost');
});

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

Route::get('/', function(){
	return view('welcome');
});

Route::get('/pusher', function() {
    event(new App\Events\UserListing('Hi there Pusher!'));
    return "Event has been sent!";
});

Auth::routes();

Route::get('google', function () {
    return view('googleAuth');
});

Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');

Route::group(['middleware' => ['auth']], function() {

	Route::get('/home', ['uses'=>'HomeController@index'])->name('home');
	Route::get('/users', ['uses'=>'HomeController@userlist'])->name('userlist');
	Route::get('/createComplaints', ['uses'=>'HomeController@createComplaints'])->name('createcomplaints');
	Route::post('posts/loadPosts', ['uses'=>'PostController@loadPosts'])->name('posts.loadPosts');
	Route::post('/savepost', ['uses'=>'PostController@savepost'])->name('savepost');

	Route::post('/changestatus', ['uses'=>'HomeController@changestatus'])->name('changestatus');
	Route::get('/listcomplaints', ['uses'=>'HomeController@listcomplaints'])->name('listcomplaints');
	Route::post('/deletecomplaints', ['uses'=>'HomeController@deletecomplaints'])->name('deletecomplaints');
	Route::get('/listpolls', ['uses'=>'HomeController@listpolls'])->name('listpolls');
	Route::post('/savepoll', ['uses'=>'HomeController@savepoll'])->name('savepoll');
	Route::post('/GetPollmodal', ['uses'=>'HomeController@GetPollmodal'])->name('GetPollmodal');
	Route::post('/detailPoll', ['uses'=>'HomeController@detailPoll'])->name('detailPoll');

	Route::post('posts/renderCreateForm', ['uses'=>'PostController@renderCreateForm'])->name('posts.renderCreateForm');
	Route::post('posts/create', ['uses'=>'PostController@create'])->name('posts.create');
	Route::get('/poll/create','PostController@createpoll');
	Route::get('/post/view/{post_id}','PostController@getpostdetails')->name('posts.view');
	Route::post('/post/comments','PostController@getcomments')->name('loadcomments');
	Route::post('/post/comments/add','PostController@addcomment')->name('addcomment');
});




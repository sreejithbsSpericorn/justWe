<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;
use Auth;
use Exception;
use App\User;
use Redirect;
use Session;
use App\Events\UserListing;


use Illuminate\Http\Request;
class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	public function redirectToGoogle()
	{
		return Socialite::driver('google')->redirect();
	}
	public function login(Request $request) {
		//dd($request->all());
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		$credentials = array_add($credentials, 'active', 0);
		$credentials = array_add($credentials, 'is_delete', 0);
		$credentials = array_add($credentials, 'user_type', [1,2]);


		if (Auth::attempt($credentials, $request->has('remember'))) {

			if(Auth::user()->user_type == 1){

				return redirect('users');
			}else if(Auth::user()->user_type == 2){
				return redirect('createComplaints');
			}else{
				return redirect('home');
			}
		}else{
			return redirect('login')->withErrors(['These credentials do not match our records.']);
			return redirect::back()->withInput()->withFlashMessage('These credentials do not match our records.');
		}
	}

	public function handleGoogleCallback()
	{


		$user = Socialite::driver('google')->stateless()->user();
// only allow people with @company.com to login
		if(explode("@", $user->email)[1] !== 'spericorn.com'){

			return redirect('login')->withErrors(['domain not valid']);
		}


		$finduser = User::where('google_id', $user->id)->first();


		if($finduser){
			if($finduser->is_delete == 0 && $finduser->active == 0){
				Auth::login($finduser,True);

			    return  redirect('home');
			}else{
				return  redirect('/')->withErrors(['This user is Deactivated']);
			}

			

		}else{


			$newUser = User::create([
				'name' => $user->name,
				'email' => $user->email,
				'google_id'=> $user->id
			]);
			event(new UserListing('Hi there Pusher!'));
			Auth::login($newUser,True);




			return  redirect('home');
		}


	}
}

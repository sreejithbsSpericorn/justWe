<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use App\PostType;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		if(Auth::user()->user_type == 3){
		 	$post_types = PostType::where('status', 0)->get();
		  	return view('home', compact('post_types'));
		}else{
		  return view('errors.403');
		}
	}
	public function createComplaints()
	{
		if(Auth::user()->user_type == 2){
		  return view('anonymous.create');
		}else{
		  return view('errors.403');
		}
	}
   public function userlist(Request $request)
	{
		//$users = User::where('user_type',3)->paginate(10);
		if(Auth::user()->user_type == 1){
			$results = DB::connection('mysql')
			->select(DB::raw('CALL GetUsers(3,0)'));
			$users = $this->getPaginate($request,$results);
			if ($request->ajax()) {
				$results = DB::connection('mysql')
				->select(DB::raw('CALL GetUsers(3,0)'));

				$users = $this->getPaginate($request,$results);
			 return view('users.ajax.list', compact('users'));
			}
			return view('users.list',compact('users'));
		}else{
		  return view('errors.403');
		}

	}
	public function getPaginate($request,$results){
		$currentPage = LengthAwarePaginator::resolveCurrentPage();

		 //Create a new Laravel collection from the array data
		$collection = new Collection($results);

		//Define how many items we want to be visible in each page
		$perPage = request('pageBy', 20);

		//Slice the collection to get the items to display in current page
		$currentPageSearchResults = $collection->slice(($currentPage - 1) * $perPage, $perPage)->all();

		//Create our paginator and pass it to the view
		$paginatedSearchResults= new LengthAwarePaginator($currentPageSearchResults, count($collection), $perPage);
		$paginatedSearchResults->setPath($request->url());
		$paginatedSearchResults->appends($request->except(['page']));
		return $paginatedSearchResults;
	}


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
class PostController extends Controller
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
     public function savepost(Request $request)
    {
        $input =$request->all();

        $data = array(
        	'created_by' =>Auth::user()->id, 
        	'user_id' =>Auth::user()->id, 
        	'title' =>$input['title'], 
        	'descriptions' =>$input['descriptions'],
        	'post_type' =>4
        );
        Post::create($data);
        print json_encode(array('status'=>'success','message'=>'Complaints created successfully'));
    }
}
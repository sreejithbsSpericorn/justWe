<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\PostComment;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

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

        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required | min:10',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        $data = array(
            'created_by' => Auth::user()->id,
            'user_id' => Auth::user()->id,
            'title' => $input['title'],
            'descriptions' => $input['description'],
            'post_type' => 4
        );
        Post::create($data);
        return response(['status' => 'success', 'message' => 'Complaints created successfully']);
    }
    function getpostdetails($id)
    {
        $comments =  PostComment::leftJoin('users', 'users.id', '=', 'post_comments.user_id')
        ->where(['post_comments.post_id' => $id])
        ->select('*', 'post_comments.created_at')
        ->orderBy('post_comments.id','DESC')
        ->get();

        $post = Post::where('post_type', 1)
            ->orWhere('post_type', 2)
            ->where('id', $id)
            ->first();    

        $user = User::find($post->user_id);
        if ($post) {
            return view('posts.view', compact('post','user','comments'));
        }
        return view('errors.403');
        // $comments = DB('post_comments','')
        // if($post->post_type==1 || $post->post_type==2){
        //     return view('posts.view',compact('post','comments'));
        // }
        // else{
        //     dd('error');
        // }
    }

    function getComments(Request $request){
       $comments =  PostComment::leftJoin('users', 'users.id', '=', 'post_comments.user_id')
        ->where(['post_comments.post_id' => $request->id])
        ->select('*', 'post_comments.created_at')
        ->get();
        // dd($comments);
        // for ($i=0; $i < ; $i++) { 
        //     # code...
        // }
        // $comments['user'] = Auth::user()->name; 

    return response(['comments'=>$comments]);
    }
    function addcomment(Request $request){
        $input = $request->all();
        $input['user_id']= Auth::user()->id;
        $comment = PostComment::create($input); 
        // dd($comment);
        $user = User::where('id',$input['user_id'])->select()->first();
        $comment['user'] = Auth::user()->name;  
        return response(['status'=>true,'comment'=>$comment]);  
    }
    function createpoll()
    {
        return view('polls.create');
    }
}

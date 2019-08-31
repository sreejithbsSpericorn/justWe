<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\PostComment;
use DB;
use View;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use App\Events\Complaint;
use App\Events\Postsave;
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

    // Post Listing
    public function loadPosts(Request $request){

        // 0: all posts, 1: technical, 2: polls, 3: non-technical
        if($request->filter_type != "0"){
            $posts = Post::where('post_type', $request->filter_type)->orderBy('id','DESC')->get();
        } else{
            $posts = Post::whereIn('post_type', [1, 2, 3])->orderBy('id','DESC')->get();
        }

        if($posts->isNotEmpty()){
            $renderer = View::make('_includes.postListing', compact('posts'))->render();
            $result['status'] = true;
            $result['renderer'] = $renderer;
        } else{
            $result['status'] = false;
        }

        return response()->json($result);
    }

    // Render the create form
    public function renderCreateForm(Request $request){

        $post_type = $request->post_type;

        $renderer = View::make('_includes.postCreateForm', compact('post_type'))->render();
        $result['status']=true;
        $result['renderer'] = $renderer;

        return response()->json($result);
    }

    // Create new Post
    public function create(Request $request){

        $this->validate($request, [
            'post_type' => 'required',
            'title' => 'required',
            'description' => 'required',
            // 'post_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->post_type = $request->post_type;
        $post->title = $request->title;
        $post->descriptions = $request->description;

        if($request->post_type == '1' && isset($request->tags) && $request->tags){
            $post->post_tags = json_encode($request->tags);
        }

        if ($request->hasFile('post_image')) {
            $image = $request->file('post_image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/uploads/posts');
            $image->move($destinationPath, $name);
            $post->image = '/uploads/posts/' . $name;
        }

        $post->save();
       
       event(new Postsave('Hi there Pusher!'));
        return response()->json(array("status" => true));
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
            'user_id' => Auth::user()->id,
            'title' => $input['title'],
            'descriptions' => $input['description'],
            'post_type' => 4
        );
        Post::create($data);
        event(new Complaint('Hi there Pusher!'));
        return response(['status' => 'success', 'message' => 'Complaints created successfully']);
    }

    public function getpostdetails($post_id)
    {
        $comments =  PostComment::leftJoin('users', 'users.id', '=', 'post_comments.user_id')
        ->where(['post_comments.post_id' => $post_id])
        ->select('*', 'post_comments.created_at')
        ->orderBy('post_comments.id','DESC')
        ->get();

        $post = Post::where('id', $post_id)->whereIn('post_type', [1, 2])->first();

        if ($post) {
            return view('posts.view', compact('post','comments'));
        }
        return view('errors.403');
    }

    public function addcomment(Request $request){
        $input = $request->all();
        $input['user_id']= Auth::user()->id;
        $comment = PostComment::create($input);
        $user = User::where('id',$input['user_id'])->select()->first();
        $comment['user'] = Auth::user()->name;

        return response(['status'=>true,'comment'=>$comment]);
    }

    public function createpoll()
    {
        return view('polls.create');
    }
}

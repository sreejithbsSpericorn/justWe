<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use DB;
use View;
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

        return response()->json(array("status" => true));

    }
}
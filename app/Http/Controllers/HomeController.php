<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use DB;
use View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\Validator;
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
        return view('home');
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
  function changestatus(Request $request){
    $input = $request->all();
    if($input['type'] == 'activate'){
      $data = array('active' =>0);
      $message= "Activated Succesfully";

    }else if($input['type'] == 'deactivate'){
      $data = array('active' =>1);
      $message= "Deactivated Succesfully";
    }else if($input['type'] == 'delete'){
      $data = array('is_delete' =>1);
      $message= "Deleted Succesfully";
    }else{
     print json_encode(array('status'=>'failed','message'=>'Something went Wrong!!'));
   }
   User::find($input['id'])->update($data);
   print json_encode(array('status'=>'success','message'=>$message));

 }
 public function listcomplaints(Request $request)
 {
  if(Auth::user()->user_type == 1){
    $results = DB::connection('mysql')
    ->select(DB::raw('CALL GetPosts(4,0)'));
    $post = $this->getPaginate($request,$results);
    if ($request->ajax()) {
      $results = DB::connection('mysql')
      ->select(DB::raw('CALL GetPosts(4,0)'));

      $post = $this->getPaginate($request,$results);
      return view('complaints.ajax.list', compact('post'));
    }
    return view('complaints.list',compact('post'));
  }else{
    return view('errors.403');
  }
}
function deletecomplaints(Request $request){
  $input = $request->all();
  Post::find($input['id'])->delete();
  print json_encode(array('status'=>'success','message'=>'Deleted Succesfully'));
}
public function listpolls(Request $request)
 {
  if(Auth::user()->user_type == 1){
    $results = DB::connection('mysql')
    ->select(DB::raw('CALL GetPosts(3,0)'));
    $post = $this->getPaginate($request,$results);
    if ($request->ajax()) {
      $results = DB::connection('mysql')
      ->select(DB::raw('CALL GetPosts(3,0)'));

      $post = $this->getPaginate($request,$results);
      return view('polls.ajax.list', compact('post'));
    }
    return view('polls.list',compact('post'));
  }else{
    return view('errors.403');
  }
}
public function savepoll(Request $request)
 {
  $input = $request->all();
  $validator = Validator::make($input, [
    'title' => 'required| min:10',
    
 ]);

 if($validator->fails()){
    
     print json_encode(array('status'=>'failed','message'=>$validator->errors()->first()));
 }
  $data =  array('user_id' =>Auth::user()->id,'post_type' =>3, $input['title'],'title' => $input['title'],'expire_date' =>$input['expiry_date'] );
  $post = Post::create($data);
  $option = $request->input('option');
  
  foreach ($option as $value) {
    $datas=array(
        'post_id'     => $post->id, 
        'options'   =>$value
    );
    DB::table('post_options')->insert($datas);
  }
    print json_encode(array('status'=>'success','message'=>'Poll Created Succesfully'));

 
 }
 public function GetPollmodal(Request $request)
 {
  $input = $request->all();
  $html =  View::make('polls.ajax.create')->render();
   print json_encode(array('status'=>'success','message'=>'Created Succesfully','html'=>$html));
 }
 public function detailPoll(Request $request)
 {
  $input = $request->all();
  $post = Post::where('post_type',3)->where('id',$input['id'])->first();
  $post_options = Post::join('post_options','post_options.post_id','=','posts.id')
  ->leftjoin("pollings",'pollings.post_options_id','=','post_options.id')
  ->select('posts.*','post_options.options',DB::raw("COUNT(pollings.id) as polling_count"))
  ->where('posts.id',$input['id'])
  ->groupBy('post_options.id')
  ->orderBy('post_options.id','ASC')
  ->get();
  $totalcount = DB::table('post_options')->where('post_id',$input['id'])->count();
  $html =  View::make('polls.ajax.detailview',compact('post','post_options','totalcount'))->render();
   print json_encode(array('status'=>'success','message'=>'Created Succesfully','html'=>$html));
 }


}

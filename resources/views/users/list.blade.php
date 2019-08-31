@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
		@if (\Session::has('msg'))
		    <div class="alert alert-danger">
			<ul>
			    <li>{!! \Session::get('msg') !!}</li>
			</ul>
		    </div>
		@endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                     <div id="userlist">
                        @include('users.ajax.list')
                     </div>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 @section('scripts')
   
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
  

     <script>

    var pusher = new Pusher('09143f0b85f847fa4a08', {
    encrypted: true
});

// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('user-listing');

// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\UserListing', function(data) {
    // this is called when the event notification is received...
//alert(1);
getuserlist(1);
});
      $(document).ready(function()
      {
        
         getuserlist(1);
       });
 
function getuserlist(page){
  
  $.ajax(
  {
    url: '?page=' + page,
    type: "get",
    datatype: "html",
            // beforeSend: function()
            // {
            //     you can show your loader 
            // }
          }) 
  .done(function(data)
  {
            //console.log(data);
            
            
            $("#userlist").html("<div>"+data+"</div>");
            //GetlocDetails();
            
            
          })
  .fail(function(jqXHR, ajaxOptions, thrownError)
  {
    alert('No response from server');
  });

}


</script>
@endsection

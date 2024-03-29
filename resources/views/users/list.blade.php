@extends('layouts.app')

@section('content')




<div class="container">


  <div class="row justify-content-center">
    <div class="col-md-12">
      
        
        @if (\Session::has('msg'))
        <div class="alert alert-danger">
         <ul>
           <li>{!! \Session::get('msg') !!}</li>
         </ul>
       </div>
       @endif
       
        <div class="statusmessage">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
        
        @endif
        </div>
        <div id="userlist">
          @include('users.ajax.list')
        </div>

  </div>
</div>
</div>
 <div id="DeleteModal" class="modal fade modal-message modal-categ mod-csh mod-prd mod-del modal-alert" role="dialog" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <!--<div class="modal-header">
                  </div>-->
               <div class="modal-body">
                <input type="hidden" id="userid">
                <input type="hidden" id="usertype">
                  <h3> Are you sure you want to <span class="types-msg"></span>?</h3>
                  
               </div>
               <div class="modal-footer">
                     <button type="button" class="btn btn-secondary btn-sec-tw" data-dismiss="modal">No</button>
                     <button type="button" class="btn btn-info btn-fill" onclick="Changetype()" >Yes</button>
                </div>
            </div>
         </div>
      </div>
@endsection
@section('scripts')


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
var page = $(".pagination li.active span.page-link").text();
 getuserlist(page);
});
 $(window).on('hashchange', function() {
  if (window.location.hash) {
    var page = window.location.hash.replace('#', '');
    if (page == Number.NaN || page <= 0) {
      return false;
    }else{
      getuserlist(page);
    }
  }
});
$(document).ready(function()
{

 getuserlist(1);
 $(document).on('click', '.pagination a',function(event)
  {
    $('li').removeClass('active');
    $(this).parent('li').addClass('active');
    event.preventDefault();
    var myurl = $(this).attr('href');
    var page=$(this).attr('href').split('page=')[1];
    getuserlist(page);
  });

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
function Changestatus(elm){
  var type=$(elm).data('type');
  var id=$(elm).data('id');
  $("#userid").val(id);
  $("#usertype").val(type);
  if(type=='deactivate'){
    $(".types-msg").html('deactivate');
 
  }else if(type=='activate'){
     $(".types-msg").html('activate');

  }else{
     $(".types-msg").html('delete');

  }

  $("#DeleteModal").modal('show');


}
function Changetype(){
  var id = $("#userid").val();
  var type= $("#usertype").val();
  $.ajax({
    url: "{{ route('changestatus') }}",
    type: 'POST',
    data: {'id':id,'type':type,'_token':CSRF_TOKEN},

    success: function (data) {
      var data = JSON.parse(data);
      $(".statusmessage").show();
      $("#DeleteModal").modal('hide');
      if(data.status=='success' ){
        $(".statusmessage").html('<div class="alert alert-success"><p>'+data.message+'</p></div>');

        var page = $(".pagination li.active span.page-link").text();
        
        getuserlist(page);
      }else{
        $(".statusmessage").html('<div class="alert alert-danger"><p>'+data.message+'</p></div>');
      }
      setTimeout(function(){
        $(".statusmessage").fadeOut();
        $(".statusmessage").html(' ');
            // location.reload();

      }, 3000);



    },
    error: function (data) {

    }
  });
}


</script>
@endsection

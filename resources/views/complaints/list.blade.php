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
        <div id="postlist">
          @include('complaints.ajax.list')
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
                <input type="hidden" id="postid">
                <input type="hidden" id="posttype">
                  <h3> Are you sure you want to Delete?</h3>
                 
               </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-secondary btn-sec-tw" data-dismiss="modal">No</button>
                     <button type="button" class="btn btn-info btn-fill" onclick="Delete()" >Yes</button>
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
var channel = pusher.subscribe('complaint');

// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\Complaint', function(data) {
    // this is called when the event notification is received...
//alert(1);
var page = $(".pagination li.active span.page-link").text();
 postlist(page);
});
$(document).ready(function()
{

 postlist(1);
 $(document).on('click', '.pagination a',function(event)
  {
    $('li').removeClass('active');
    $(this).parent('li').addClass('active');
    event.preventDefault();
    var myurl = $(this).attr('href');
    var page=$(this).attr('href').split('page=')[1];
    postlist(page);
  });

 });
function postlist(page){

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
            
            
            $("#postlist").html("<div>"+data+"</div>");
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
  $("#postid").val(id);
  $("#posttype").val(type);
  

$("#DeleteModal").modal('show');

}
function Delete(){
  var type= $("#posttype").val();
  var id=$("#postid").val();
  $.ajax({
    url: "{{ route('deletecomplaints') }}",
    type: 'POST',
    data: {'id':id,'type':type,'_token':CSRF_TOKEN},

    success: function (data) {
      var data = JSON.parse(data);
      $("#DeleteModal").modal('hide');
      $(".statusmessage").show();
      if(data.status=='success' ){
        $(".statusmessage").html('<div class="alert alert-success"><p>'+data.message+'</p></div>');

        var page = $(".pagination li.active span.page-link").text();
        
        postlist(page);

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

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

        <div class="row">
          <div class="container-fluid d-flex mb-2">
              <button type="button" class="btn btn-info  float-right" onclick="GetPollmodal()">Add Polls</button>
          </div>
        </div>

        
        

        <div id="postlist">
          @include('polls.ajax.list')
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
       <!-- Modal -->
       <div id="myModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        
      </div>
      @endsection
      @section('scripts')

      
      <script src="//js.pusher.com/3.1/pusher.min.js"></script>


      <script>
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
        function AddOptions(){
         $('.options').append('<div class="opt-input-con"><input type="text" class="form-control" name="option[]"><span class="error"></span> <a onclick="removeoptions(this)" class="remove-opt text-danger" >Remove</a></div>');

       }
function SaveOptions(){

  var arrays = new Array();
  var error_status = 'true';
  $(".error").hide();
  $("span.error").html(' ');
  if($(".titles").val() == ''){
    $(".error_title").show();
    $('.error_title').html('Title is required');
     var error_status = 'false';

  }if($(".expiry_date").val() == ''){
    $(".error_expiry_date").show();
    $('.error_expiry_date').html('Date is required');
     var error_status = 'false';

  }
  i = 1;
  $('input[name="option[]"]').each(function(){
    if($(this).val()==""){
     $(this).next('span').show();
     $(this).next('span').html('<span class="error">Value is required</span>');
      var error_status = 'false';
   }
   else{
     arrays.push($(this).val());
     $(this).next('span').hide();
     $(this).next('span').html('<span class="error"></span>');

     if($('input[name="option[]"]').length == i )
       if(arrays.length<2){
        $(".error_option").show();
        $('.error_option').text('Minimum 2 options required');
        var error_status = 'false';
      }
      else{
        $(".error_option").hide();
        $('.error_option').text('');
        var error_status = 'true';
      }

    }  
    i++;    
  });
  
  if(error_status != 'false' && $('input[name="option[]"]').length>=2){
    $.ajax({
     url: "{{ route('savepoll') }}",
     type: 'POST',
     data: $('#pollform').serializeArray(),

     success: function (data) {
       var data = JSON.parse(data);
      

      if(data.status == 'success'){
         $('#pollform')[0].reset();
         $("#myModal").modal('hide');

        $(".statusmessage").html('<div class="alert alert-success"><p>'+data.message+'</p></div>');
         var page = $(".pagination li.active span.page-link").text();

          postlist(page);
      }else{
        if(data.message){
          $('.error_title').show();
          $('.error_title').html(data.message);
        }else{
          $(".statusmessage").html('<div class="alert alert-danger"><p>'+data.message+'</p></div>');
        }
         setTimeout(function(){
                $(".statusmessage").fadeOut();
                $(".statusmessage").html(' ');
            // location.reload();

          }, 3000);
        

      }



    },
    error: function (data) {}
    });
  }
 }
 function GetPollmodal(){
  $.ajax({
    url: "{{ route('GetPollmodal') }}",
    type: 'POST',
    data: {'_token':CSRF_TOKEN},

    success: function (data) {
      var data = JSON.parse(data);
      
      if(data.status=='success' ){
        $("#myModal").html(data.html);
        $("#myModal").modal('show');

        

      }else{
       
      }
     



    },
    error: function (data) {

    }
  });
 }function removeoptions(elm){
   $(elm).closest('.opt-input-con').remove();
 }
 function Detailview(elm){
  var id = $(elm).data('id');
  $.ajax({
    url: "{{ route('detailPoll') }}",
    type: 'POST',
    data: {'_token':CSRF_TOKEN,'id':id},

    success: function (data) {
      var data = JSON.parse(data);
      
      if(data.status=='success' ){
        $("#myModal").html(data.html);
        $("#myModal").modal('show');

        

      }else{
       
      }
     



    },
    error: function (data) {

    }
  });
 }

    </script>
    @endsection

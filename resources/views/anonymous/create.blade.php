@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard Anonymous</div>
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

                    <form 
                    method="POST" data-parsley-validate="parsley" id="myForm" action="{{ route('savepost') }}" enctype="multipart/form-data" >
                    {{ csrf_field() }}

                    Title
                    <input type="text" name="title" required>
                    Descriptions
                    <input type="text" name="descriptions" required>
                    
                    
                    <button type="button" id="Filesave" onclick="SavePost()" class="form_s_c btn-01 btn btn-success btn-fill btn-block">Save </button>
                    
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('scripts')
<script src="https://malsup.github.io/jquery.form.js"></script>
<script>
 
    function SavePost(){
        alert();
//if($('#myForm').parsley().validate()){
  
//   $('#myForm').ajaxForm(function(options) {
//     var options = JSON.parse(options);

// if(options.status == 'success'){
//  $('#myForm')[0].reset();




//     }else{
//      $(".message").show();
//      $(".message").html('<div class="alert alert-danger"><p>'+options.message+'</p></div>');
//      pos = $(".message").offset().top;
//      $("html,body").animate({scrollTop:pos-300}, 1000);
//      setTimeout(function(){

//       $(".message").hide();
//       $(".message").html('');

//     }, 3000);

//    }
//  });
$.ajax({
   url: '{{ route('savepost') }}',
   type: 'POST',
   data: $('#myForm').serializeArray(),
   
   success: function (data) {
     var data = JSON.parse(data);
     $(".POS-loader").hide();
     
     if(data.status == 'success'){
      
      alert();
  }else{
   
  }
  
  
  
},
error: function (data) {
                 // console.log(data.responseText);
             }
         });

//}
}
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard Anonymous</div>
                <div class="message"></div>
                    <form method="POST" id="myForm" action="{{ route('savepost') }}" enctype="multipart/form-data" >
                    {{ csrf_field() }}

                    Title
                    <input type="text" name="title" id="title" required>
                    <span class="error" id="titleError"></span>
                    Descriptions
                    <textarea name="description" id="" cols="30" rows="7" id="description" required></textarea>
                    <span class="error" id="descError"></span>
                    <button type="button" id="Filesave" onclick="SavePost()" class="form_s_c btn-01 btn btn-success btn-fill btn-block">Make complaint </button>
                    
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
        if($('#title').val() === ''){
            $('#titleError').text('title is required');
        }
        else{
            $('#titleError').text('');
        }
        if($('#description').text() ===''){
            $('#descError').text('Description is required');
        }
        else{
            $('#descError').text('');
        }
    $.ajax({
     url: '{{ route('savepost') }}',
     type: 'POST',
     data: $('#myForm').serializeArray(),
     success: function (data) {
    //  var data = JSON.parse(data);
    //  console.log('data', data)
     if(data.status =='success'){
         $('#myForm').trigger('reset');
         $('.message').text(data.message);
         $('.error').hide();
         }
         else{
            $('#myForm').trigger('reset');
             if(data.title){
                 $('#titleError').text(data.title[0])
             }
             if(data.description){
                $('#descError').text(data.description[0])
             }
         }
     }
    });
//}
}
</script>
@endsection

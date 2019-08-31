@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center" style="padding:30px 0px;">
        <div class="col-md-8">
            <div class="">
                <div class="text-ce">
                    <h2 class="text-center">
                       Send a Message Anonymously
                    </h2>

            </div>
                <div class="message" style="color:green;">
                </div><br/>
                    <form method="POST" id="myForm" action="{{ route('savepost') }}" enctype="multipart/form-data" >
                    {{ csrf_field() }}

                    Title
                    <div class="form-group">
                         <input class="form-control" type="text" name="title" id="title" required>
                    </div>


                    <span class="error" id="titleError"></span>
                    Description
                    <div class="form-group">
                    <textarea style="width: 100%" name="description" id="" cols="30" rows="7" id="description" required></textarea>
                         </div>
                    <span class="error" id="descError"></span>
                    <div class="text-center">
                        <button type="button" id="Filesave" onclick="SavePost()"
                     class="form_s_c btn-01 btn btn-primary btn-fill">Send complaint </button>
                    </div>


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
        if($('#description').val() ===''){
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
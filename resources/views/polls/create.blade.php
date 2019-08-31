@extends('layouts.app')

@section('content')
        <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Create poll</div>
                            <div class="message"></div>
                            <form action="#" method="post"></form>
                            <div class="card-body">
                                <div class="form-control">
                                    <label for="title">Poll Title</label>
                                        <input type="text" name="title">
                                        <span class="error"></span>
                                </div>
                                <div class="form-control options">
                                    <input type="text" name="option[]">
                                    <span class="error"></span>
                                </div>  
                            </div>
                            <div class="card-footer">
                                    <div class="form-control">
                                       <button type="button" onclick="addOption()">Add</button>
                                       <button type="button" onclick="savePoll()">Create</button>
                                    </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('scripts')
<script src="https://malsup.github.io/jquery.form.js"></script>
<script>
    // $(document).ready(function(){
    //     // var i=1;
    // });
    function addOption(){
        $('.card-body').append('<div class="form-control"><input type="text" name="option"><span class="error"></span></div>');
    }
    function savePoll(){
        var array = new Array();
        console.log('array', array)
        $('input[type=text]').each(function(){
            if($(this).val()==""){
               $(this).next('span').html('<span class="error">Value is required</span>');
            }
            else{
               array.push($(this).val());
               if(array.length<3){
                 $('.message').text('Minimum 2 options required');
                }
                else{
                $('.message').text('');
              }
              $(this).next('span').html('<span class="error"></span>');
               
            }      
     });
    }
</script>
@endsection

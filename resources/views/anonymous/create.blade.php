{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard Anonymous</div>
                <div class="message"></div>
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
@endsection --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="apple-touch-icon" sizes="57x57" href="images/icon.ico">
    <link rel="apple-touch-icon" sizes="60x60" href="images/icon.ico">
    <link rel="apple-touch-icon" sizes="72x72" href="images/icon.ico">
    <link rel="apple-touch-icon" sizes="76x76" href="images/icon.ico">
    <link rel="apple-touch-icon" sizes="114x114" href="images/icon.ico">
    <link rel="apple-touch-icon" sizes="120x120" href="images/icon.ico">
    <link rel="apple-touch-icon" sizes="144x144" href="images/icon.ico">
    <link rel="apple-touch-icon" sizes="152x152" href="images/icon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="images/icon.ico">
    <link rel="icon" type="image/png" sizes="192x192" href="images/icon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="images/icon.ico">
    <link rel="icon" type="image/png" sizes="96x96" href="images/icon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="images/icon.ico">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="images/icon.ico">
    <meta name="theme-color" content="#ffffff">

    <!-- Style -->
    <link rel="stylesheet" href="css/style.css" />
    <!--Animate.css-->
    <link rel="stylesheet" href="css/animate.css" />
    <!--Bootstrap-->
    <link rel="stylesheet" href="css/bootstrap.min.css" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,700i&display=swap" rel="stylesheet">
</head>
<body>
        <div class="container-fluid p-0">
                  <!--Begin Header-->

        <header class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar">
                <div class="container">
                    <a class="navbar-brand mr-0 mr-md-2" href="/" aria-label="Bootstrap">
                        <img src="images/justWe-logo-white1.png" class="img-fluid">
                    </a>
                    <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
                        <div class="header-profile-pic">
                            <p>A</p>
                        </div>
                        <div class="btn-group">
                            <a class="pro-username" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Anumol <span class="arrow">
                                    <img src="images/24x24.png" class="img-fluid">
                                </span>
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Profile</a>
                                <a class="dropdown-item" href="#">Logout</a>
                            </div>
                        </div>
                    </ul>
                </div>
            </header>
    
            <!-- End Header-->
            <div class="container anonyms-container">

                    <div class="anonyms-wraper">
                            <div class="col-md-6">
                                <form method="POST" id="myForm" action="{{ route('savepost') }}" enctype="multipart/form-data" >
                                        <div class="form-group">
                                          <label for="email">Title</label>
                                          <input type="text" class="form-control" id="title" placeholder="Enter Complaint title" name="email">
                                        </div>
                                        <div class="form-group">
                                          <label for="pwd">Description</label>
                                       <textarea rows="4" class="form-control" ></textarea>
                                        </div>
                                      
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>


                    </div>
            </div>



            </div>

        </div>
   <script src="js/vendor/jquery-3.3.1.slim.min.js"></script>
    <script src="js/vendor/popper.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
</body>
</html>

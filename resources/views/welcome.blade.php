<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Just We Login</title>

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <!--Animate.css-->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" />
    <!--Bootstrap-->
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,700i&display=swap" rel="stylesheet">
    
</head>

<body>

        <div class="container-fluid login-page-wrap flex-column">
                   @if($errors->any())
                        <div class="alert alert-danger">{{$errors->first()}}</div>
                    @endif
                    <div class="login-area">
                        <div class="login-logo">
                                <img src="{{ URL::asset('assets/img/logo-admin-white.png') }}" class="img-fluid">
                        </div>
                        <div class="login-button">
                            <a href="auth/google" class="login-btn">Login to continue <span><img src="images/24x24-arrow.png" class="img-fluid"></span> </a>
                        </div>
                       

                    </div>



        </div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


</body>
</html>
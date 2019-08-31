<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Just WE') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  

    
    <style type="text/css">
        html, body{
            height:100%;
            font-family: 'Open Sans', sans-serif;
        }
        .login-con{
            background: #134563; 
            background: -moz-linear-gradient(-45deg, #134563 0%, #487793 32%, #487793 39%, #134563 64%); 
            background: -webkit-linear-gradient(-45deg, #134563 0%,#487793 32%,#487793 39%,#134563 64%); 
            background: linear-gradient(135deg, #134563 0%,#487793 32%,#487793 39%,#134563 64%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#134563', endColorstr='#134563',GradientType=1 ); 
            min-height: 100vh;
        }
        .login-con .logo-brand{
            height: 80px;
            width: auto;
            margin-bottom: 15px;
        }
        .login-con .card-body{
            padding: 50px 60px;
        }
        .login-con .card-header{
            font-size: 20px;
            color: #134563;
        }

        .login-con .form-group{
            margin-bottom: 28px;
        }
        .login-con .form-group.btn-con{
            padding-top: 15px;
        }
        .form-group.hasFloatingSpan{
            position: relative;
        }
        .form-group.hasFloatingSpan input[type="text"]{
            padding-top: 18px;
            font-weight: 500;
            z-index: 1;
            position: relative;
            background: transparent;
            padding: 5px 15px 5px 15px;
        }

        .form-group span.floatingSpan{
            position: absolute;
            top: 9px;
            left: 15px;
            font-size: 16px;
            transition: all 0.15s ease-In-Out;
            z-index: 0;
            display: inline-block;
            padding: 0px 12px;
        }
        .tab-pane-flex .form-group span.floatingSpan{
            top: 10px;
        }

        .form-control-opt-menu{
            position: relative;
        }
        .form-control-opt-menu:after{
            display: block;
            position: absolute;
            content: "";
            width: 0px;
            height: 0px;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.25s ease-In-Out;
            background: #eeeeee;
            z-index: -1;
        }
        .form-control-opt-menu:hover::after{
            width: 30px;
            height: 30px;
        }
        .form-control-opt-menu:active::after{
            background: #dddddd;
        }
        .form-control-opt-menu img{
            height: 20px;
            opacity: 0.7;
        }
        .form-control-opt-menu:hover img{
            opacity: 1;
        }

        .login-con .form-control{
            height: 44px;
            border-radius: 5px;
            border: 1px solid #999999;
            z-index: 1;
            position: relative;
            background: transparent;
        }
        .login-con .login-module{
            width: 450px;
            box-shadow: 0px 0px 21px 0px rgba(0, 0, 0, 0.35);
        }

        .tab-pane-flex.margin-bottom-15 .form-group.has-an-error{
            margin-bottom: 50px;
        }
        .tab-pane-flex .form-group input[type="email"], .tab-pane-flex .form-group textarea{
            background: transparent;
            position: relative;
            padding-top: 12px;
            z-index: 1;
        }
        .form-group input[type="email"]:not([value=""]) ~ span.floatingSpan, .form-group input[type="password"]:not([value=""]) ~ span.floatingSpan, .form-group textarea:not([value=""]) ~ span.floatingSpan, .form-group input[type="email"]:focus ~ span.floatingSpan, .form-group input[type="password"]:focus ~ span.floatingSpan, .form-group textarea:focus ~ span.floatingSpan{
                top: -12px;
                background: #ffffff;
                font-size: 14px;
                z-index: 1;
                color: #134563;

            }
    .form-group input[type="email"]:focus, .form-group input[type="password"]:focus, .form-group textarea:focus, .form-group input[type="email"]:not([value=""]), .form-group input[type="password"]:not([value=""]){
            border: 2px solid #134563;
            box-shadow: none;
            outline: 0;
        }
        
        .btn.btn-login{
            color: #fff;
            font-size: 16px;
            border: 1px solid #ff8400 !important;
              outline: none;
              background: #ff8400;
              background: -moz-linear-gradient(-45deg, #ff8400 0%, #ff9a35 100%, #7db9e8 100%);
              background: -webkit-linear-gradient(-45deg, #ff8400 0%, #ff9a35 100%, #7db9e8 100%);
              background: linear-gradient(135deg, #ff8400 0%, #ff9a35 100%, #7db9e8 100%);
              filter: progid:DXImageTransform.Microsoft.gradient( startColorstr="#ff8400", endColorstr="#7db9e8",GradientType=1 );
              padding: 10px 25px;
              box-shadow: 2px 2px 15px 0px rgba(0, 0, 0, 0.25);
              color: #fff !important;
        }
        .btn.btn-login:hover{
            background : $btn-yellow !important;
            border: 1px solid $btn-yellow;
            box-shadow: none;
            box-shadow: 2px 1px 9px 0px rgba(0, 0, 0, 0.25);
            outline:0;
        }
        .btn.btn-login:active{
            background : $btn-yellow !important;
            border: 1px solid $btn-yellow;
            box-shadow: none;
        }

    </style>


</head>
<body>
    <div id="app" class="login-con d-flex justify-content-center align-items-center">
       

        <main class="py-4">
            @yield('content')
        </main>
    </div>
   
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
    
     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    </script> 
     @yield('scripts')

</body>
</html>

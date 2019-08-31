<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Just WE') }}</title>

    <!-- Scripts -->
   

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style type="text/css">
        body{
            font-family: 'Open Sans', sans-serif;
        }
        a{
            cursor: pointer;
        }
        .navbar-custom{
            background: #134563;
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .navbar-custom .logo-brand{
            height: 60px;
            padding: 0px;
        }
        .navbar-custom .navbar-brand{
            padding: 0px;
        }
        .navbar-custom .dropdown-toggle{
            color: rgba(255, 255, 255, 0.75);
        }
        .main-menu-con{
            border-bottom: 1px solid #cccccc;
            margin-bottom: 15px;
        }
        main.main-menu-outer{
            padding-top: 0px !important;
        }
        .main-menu{
            display: flex;
            padding: 0px;
            margin: 0px;
        }
        .main-menu li{
            list-style: none;
        }
        .main-menu li a{
            display: block;
            padding: 8px 25px;
            color: #134563;
            transition: all 0.25s ease;
        }
        .main-menu li.active a{
            background: #f38302;
            color: #ffffff;
        }
        .main-menu li a:hover{
            text-decoration: none;
            background: #f38302;
            color: #ffffff;
        }
            .custom-table thead th{
        background: #ffffff;
        color: #134563;
        font-size: 14px;
        font-weight: 600;
        border-top: 0;
    }
    .custom-table tbody td{
        padding: 10px 15px;
        font-size: 14px;
        color: #3c4448;
    }
    .custom-table .btn.btn-xs{
        padding: 3px 10px;
        font-size: 13px;
        color: #fff;
    }
    .custom-table .btn-warning{

    }
    .custom-table .btn.btn-xs:hover{
        color: #ffffff;
    }
    .modal-alert h3{
        font-size: 20px;
        text-align: center;
        line-height: 20px !important;
        margin-bottom: 0px;
    }
    .modal-alert .modal-body{
        padding-top: 50px;
        padding-bottom: 50px;
    }
    .modal-alert .modal-footer .btn{
        padding-left: 25px;
        padding-right: 25px;
    }
    .float-right{
        margin-left: auto;
    }
    .crate-modal-content .modal-header h4{
    font-size: 24px;
    color: #134563;
  }
  .crate-modal-content .modal-body{
    padding: 30px 40px;
  }
  
  .opt-input-con{
    position: relative;
  }
  .opt-input-con .form-control{
    padding-right: 80px;
  }
  .remove-opt{
    position: absolute;
    right: 8px;
    top: 8px;
    z-index: 1;
    display: inline-block;
    cursor: pointer;
    font-size: 12px;
  }
  span.error{
    color: red;
    font-size: 12px;
  }
  / Graph /
dl {
 display: flex;
 background-color: white;
 flex-direction: column;
 width: 100%;
 max-width: 700px;
 position: relative;
 padding: 20px;
}

dt {
 align-self: flex-start;
 width: 100%;
 font-weight: 700;
 display: block;
 text-align: center;
 font-size: 1.2em;
 font-weight: 700;
 margin-bottom: 20px;
 margin-left: 130px;
}

.text {
 font-weight: 600;
 align-items: center;
 height: 20px;
 width: 130px;
 justify-content: flex-end;
 font-size: 13px;
 color: #134563;
 text-decoration: none;
 display: block;
 margin: 0;
}

.percentage {
 font-size: 0.8em;
 line-height: 1;
 text-transform: uppercase;
 width: 100%;
 height: 40px;
 margin-bottom: 10px;
 display: flex;
 flex-flow: column;
}
.percentage:hover:after, .percentage:focus:after {
 background-color: #aaa;
}
.percentage .graph-bar {
 background: #e4e1e1;
 width: 90%;
 height: 22px;
 margin-top: 5px;
}
.percentage .poll-value {
    margin: 0;
    cursor: pointer;
    /* height: 26px; */
    margin-top: 0px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #134563;
    font-weight: 500;
    line-height: 16px;
    font-size: 16px;
    margin-left: 5px;
    padding: 1px 0px;
}

.graph {
 background-color: #f38302;
 width: 50px;
 cursor: pointer;
 height: 22px;
 margin-top: 0px;
 display: flex;
 justify-content: center;
 align-items: center;
 color: #fff;
 font-weight: 600;
}
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md  navbar-custom shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                     <img src="{{ URL::asset('assets/img/logo-admin-white.png') }}" class="logo-brand">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else



                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 main-menu-outer">

            <div class="main-menu-con">
                <div class="container">
                    <ul class="main-menu">
                        <li class="@if (Request::url() == route('userlist')) active @endif">
                            <a href="{{route('userlist')}}">Users</a>
                        </li>
                        <li class="@if (Request::url() == route('listpolls')) active @endif">
                            <a href="{{route('listpolls')}}">Polls</a>
                        </li>
                        <li class="@if (Request::url() == route('listcomplaints')) active @endif">
                            <a href="{{route('listcomplaints')}}">Complaints</a>
                        </li>
                    </ul>
                </div>
            </div>

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

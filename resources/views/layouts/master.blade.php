<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>justWe</title>

    <link rel="apple-touch-icon" sizes="57x57" href="images/justWe-logo.png">
    <link rel="apple-touch-icon" sizes="60x60" href="images/justWe-logo.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/justWe-logo.png">
    <link rel="apple-touch-icon" sizes="76x76" href="images/justWe-logo.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/justWe-logo.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <!-- <link rel="manifest" href="/manifest.json"> -->
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <!--Animate.css-->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
    <!--Bootstrap-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,700i&display=swap" rel="stylesheet">

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('css/jquery-custom-dropdown-with-checkbox.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/parsley.css') }}" rel="stylesheet"/>

    <style type="text/css">
        .create-add-form, .outer-div, .tag-div, .content-div{
            display: none;
        }
        .newsfeed-table{
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        <!--Begin Header-->
        <header class="navbar navbar-expand navbar-dark flex-column flex-md-row bd-navbar">
            <div class="container">
                <a class="navbar-brand mr-0 mr-md-2" href="{{ route('home') }}" aria-label="Home">
                    <img src="images/justWe-logo-white1.png" class="img-fluid">
                </a>
                <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
                    <div class="header-profile-pic">
                        <p>{{ Auth::user()->name[0] }}</p>
                    </div>
                    <div class="btn-group">
                        <a class="pro-username" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                            <span class="arrow">
                                <img src="{{ asset('images/24x24.png') }}" class="img-fluid">
                            </span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </ul>
            </div>
        </header>
        <!-- End Header-->

        @yield('content')

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.1/parsley.js"></script>
    <script type="text/javascript">
        var base_url = "<?php echo URL::to('/'); ?>";
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    </script>

    @yield('custom_scripts')

</body>

</html>
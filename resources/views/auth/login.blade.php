@extends('layouts.login')

@section('content')


            <div class="d-flex justify-content-center">
                <div>
                    <img src="{{ URL::asset('assets/img/logo-admin-white.png') }}" class="logo-brand">
                </div>
            </div>

            <div class="card login-module">
                <div class="card-header text-center">
                    Admin Login
                </div>
               
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">{{$errors->first()}}</div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf


                        <div class="form-group row">

                            <div class="container-fluid">
                                <div class="form-group hasFloatingSpan ">
                                     <input type="email" class="form-control " name="email" required  id="daterange" value="" onkeyup="this.setAttribute('value', this.value);" onblur="this.setAttribute('value', this.value);" onchange="this.setAttribute('value', this.value);">
                                     <span class="floatingSpan">Email Id</span>
                                     @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                     @enderror
                                </div>

                                <div class="form-group hasFloatingSpan ">
                                     <input type="password" name="password" required  class="form-control " id="daterange" value="" onkeyup="this.setAttribute('value', this.value);" onblur="this.setAttribute('value', this.value);" onchange="this.setAttribute('value', this.value);">
                                     <span class="floatingSpan">Password</span>
                                     @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                     @enderror
                                </div>

                                <div class="form-groupbtn-con">
                                    <button type="submit" class="btn btn-login btn-block">
                                    {{ __('Login') }}
                                    </button>
                                </div>

                            </div>

                        </div>

                        <!-- <div class="form-group row">



                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
 -->
                       <!--  <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->
<!-- 
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                <a class="btn btn-link" href="auth/google">
                                 Google
                             </a>

                             @if (Route::has('password.request'))
                             <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                            @endif
                        </div>
                    </div> -->
                </form>
            </div>
        </div>



@endsection

@extends('site.layouts.app')
@section('content')
    <section class="pt-100 pb-100 bg-login d-none d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6 pt-4 pb-4 border-right-login">
                    <div class="d-flex align-items-center h-100">
                        <div class="m-auto">
                            <p class="text-custom-primary text-center fw-600 mb-0"><em>Change Rules for</em></p>
                            <p class="text-custom-primary text-center fw-600 mb-3"><em>Changing Needs</em></p>
                            <img src="{{asset('public/assets/images/login/1.png')}}" alt="LOGIN" class="img-fluid">
                            <div class="mt-3">
                                <table class="w-100">
                                    <tr>
                                        <td class="text-custom-primary fw-600 w-33"><em>See it</em></td>
                                        <td class="text-custom-primary text-center fw-600"><em>Compare it</em></td>
                                        <td class="text-custom-primary text-end fw-600 w-33"><em>Buy it</em></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 pt-4 pb-4">
                    <div class="d-flex align-items-center">
                        <div class="m-auto login-form">
                            <div class="pt-4 pb-3 text-white text-center login-form-heading">
                                CUSTOMER LOGIN
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @error('email')
                                    <div class="alert alert-danger ml-3 mr-3 mt-3 mb-0 p-2 fs-13">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    @error('password')
                                    <div class="alert alert-danger ml-3 mr-3 mt-3 mb-0 p-2 fs-13">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    @if(session()->has('message'))
                                        <div class="alert alert-danger ml-3 mr-3 mt-3 mb-0 p-2 fs-13">
                                            {{ session('message') }}
                                        </div>
                                    @elseif(session()->has('error'))
                                        <div class="alert alert-danger ml-3 mr-3 mt-3 mb-0 p-2 fs-13">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <form method="POST" action="{{ route('login') }}" id="desktop-login-form">
                                @csrf
                                <input type="hidden" name="pageType" value="checkout">
                                <input type="hidden" name="g-recaptcha-response" id="response">
                                <div class="p-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-email ltn__custom-icon">
                                                <input type="email" id="email" name="email" placeholder="Email ID" class="form-control login-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-password ltn__custom-icon">
                                                <input type="password" id="password" name="password" placeholder="Password" class="form-control login-input @error('password') is-invalid @enderror">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            @if (\Illuminate\Support\Facades\Route::has('password.request'))
                                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                                    {{ 'Forgot Password?' }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-login" onclick="getLoginDesktop();">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-2">
                        <p class="m-auto text-black mb-0">
                            <span class="mr-2">Sign in With</span>
                            <a href="{{route('Login.facebook')}}"><img src="{{asset('public/assets/images/register/4.png')}}" alt="SOCIAL LOGIN 1" class="img-fluid mr-2" /></a>
                            <a href="{{route('Login.google')}}"><img src="{{asset('public/assets/images/register/6.png')}}" alt="SOCIAL LOGIN 3" class="img-fluid mr-2" /></a>

                        </p>
                    </div>
                    <div class="d-flex align-items-center mt-2">
                        <p class="m-auto text-black mb-0">
                            <span class="mr-2">Please sign-up if you are new user. <a href="{{url('register')}}" class="text-custom-primary fw-600">Sign-up</a></span>
                        </p>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <p class="fw-600 text-center">
                        <em>
                            <span class="text-dark">For more information, please call </span>
                            <span class="text-custom-primary">0325-101-101-9</span>
                        </em>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- for mobile-->
     <section class="pt-50 pb-20 bg-login d-md-none">
        <div class="container">
            <div class="row">
               <div class="col-12 pb-4">
                    <div class=" align-items-center">
                        <div class="m-auto login-form_Mob">
                            <div class="pt-4 pb-3 text-white text-center login-form-heading">
                                CUSTOMER LOGIN
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @error('email')
                                    <div class="alert alert-danger ml-3 mr-3 mt-3 mb-0 p-2 fs-13">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    @error('password')
                                    <div class="alert alert-danger ml-3 mr-3 mt-3 mb-0 p-2 fs-13">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    @if(session()->has('message'))
                                        <div class="alert alert-danger ml-3 mr-3 mt-3 mb-0 p-2 fs-13">
                                            {{ session('message') }}
                                        </div>
                                    @elseif(session()->has('error'))
                                        <div class="alert alert-danger ml-3 mr-3 mt-3 mb-0 p-2 fs-13">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <form method="POST" action="{{ route('login') }}" id="mobile-login-form">
                                @csrf
                                <input type="hidden" name="pageType" value="checkout">
                                <input type="hidden" name="" id="response-mobile">

                                <div class="p-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-email ltn__custom-icon">
                                                <input type="email" id="email" name="email" placeholder="Email ID" class="form-control login-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-password ltn__custom-icon">
                                                <input type="password" id="password" name="password" placeholder="Password" class="form-control login-input @error('password') is-invalid @enderror">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Remember Me') }}
                                                </label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            @if (\Illuminate\Support\Facades\Route::has('password.request'))
                                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                                    {{ 'Forgot Password?' }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-login" onclick="getLoginMobile();">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                   <div class="d-flex align-items-center mt-2">
                       <p class="m-auto text-black mb-0">
                           <span class="mr-2">Sign in With</span>
                           <a href="{{route('Login.facebook')}}"><img src="{{asset('public/assets/images/register/4.png')}}" alt="SOCIAL LOGIN 1" class="img-fluid mr-2" /></a>
                           <a href="{{route('Login.google')}}"><img src="{{asset('public/assets/images/register/6.png')}}" alt="SOCIAL LOGIN 3" class="img-fluid mr-2" /></a>

                       </p>
                   </div>
                    <div class="d-flex align-items-center mt-2">
                        <p class="m-auto text-black mb-0">
                            <span class="mr-2">Please sign-up if you are new user. <a href="{{url('register')}}" class="text-custom-primary fw-600">Sign-up</a></span>
                        </p>
                    </div>
                </div>
                 <div class="col-md-6  pb-4 border-right-login">
                    <div class="d-flex align-items-center h-100">
                        <div class="m-auto">
                            <p class="text-custom-primary text-center fw-600 mb-0"><em>Change Rules for</em></p>
                            <p class="text-custom-primary text-center fw-600 mb-3"><em>Changing Needs</em></p>
                            <img src="{{asset('public/assets/images/login/1.png')}}" alt="LOGIN" class="img-fluid">
                            <div class="mt-3">
                                <table class="w-100">
                                    <tr>
                                        <td class="text-custom-primary fw-600 w-33"><em>See it</em></td>
                                        <td class="text-custom-primary text-center fw-600"><em>Compare it</em></td>
                                        <td class="text-custom-primary text-end fw-600 w-33"><em>Buy it</em></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <p class="fw-600 text-center">
                        <em>
                            <span class="text-dark">For more information, please call </span>
                            <span class="text-custom-primary">0325-101-101-9</span>
                        </em>
                    </p>
                </div>
            </div>
        </div>
    </section>
    
     <!--Recaptcha Desktop and Mobile-->
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LcUceMfAAAAACPs5b7QopMRLfY2CeRZI37yIf94"></script>
    <script>
        function getLoginDesktop()
        {
            grecaptcha.ready(function(){
                grecaptcha.execute('6LcUceMfAAAAACPs5b7QopMRLfY2CeRZI37yIf94',{ action: "submit" }).then(function(token){
                  if(token){
                      document.getElementById('response').value=token;
                      $("#desktop-login-form").submit();
                  }
                })
            });
        }
		
		function getLoginMobile()
        {
            grecaptcha.ready(function(){
                grecaptcha.execute('6LcUceMfAAAAACPs5b7QopMRLfY2CeRZI37yIf94',{ action: "submit" }).then(function(token){
                  if(token){
                      document.getElementById('response-mobile').value=token;
                      $("#mobile-login-form").submit();
                  }
                })
            });
        }
    </script>
@endsection
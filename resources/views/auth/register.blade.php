@extends('site.layouts.app')
@section('content')
    <section class="pt-100 pb-100 bg-login d-none d-md-block">
        <div class="container">
            <div class="row">
                <div class="col-md-6 pt-4 pb-4 border-right-login">
                    <div class="d-flex align-items-center h-100">
                        <div class="m-auto">
                            <img src="{{asset('public/assets/images/register/1.png')}}" alt="REGISTER 1" class="img-fluid mb-3">
                            <img src="{{asset('public/assets/images/register/2.png')}}" alt="REGISTER 1" class="img-fluid mb-3">
                            <img src="{{asset('public/assets/images/register/3.png')}}" alt="REGISTER 1" class="img-fluid mb-3">
                            <p class="text-custom-primary fw-600 fs-x-large line-height-1-3 mb-0"><em>You’re in safe zone, so browse
                                    & shop confidently</em></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 pt-4 pb-4">
                    <div class="d-flex align-items-center">
                        <div class="m-auto login-form">
                            <div class="pt-4 pb-3 text-white text-center login-form-heading">
                                SIGN UP
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @error('name')
                                    <div class="alert alert-danger ml-3 mr-3 mt-3 mb-0 p-2 fs-13">
                                        {{ $message }}
                                    </div>
                                    @enderror
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
                            <form method="POST" action="{{ route('register') }}" id="desktop-register-form">
                                @csrf
                                <input type="hidden" name="g-recaptcha-response" id="response">
                                <div class="p-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-name ltn__custom-icon">
                                                <input type="text" id="first_name" name="first_name" placeholder="First Name"
                                                       class="form-control login-input  @error('first_name') is-invalid @enderror"
                                                       value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-name ltn__custom-icon">
                                                <input type="text" id="last_name" name="last_name" placeholder="Last Name"
                                                       class="form-control login-input  @error('last_name') is-invalid @enderror"
                                                       value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-email ltn__custom-icon">
                                                <input type="email" id="email" name="email" placeholder="Email ID"
                                                       class="form-control login-input @error('email') is-invalid @enderror"
                                                       value="{{ old('email') }}" required autocomplete="email"
                                                       autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-password ltn__custom-icon">
                                                <input type="password" id="password" name="password"
                                                       placeholder="Password"
                                                       class="form-control login-input @error('password') is-invalid @enderror"
                                                       required autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-password ltn__custom-icon">
                                                <input type="password" id="password-confirm"
                                                       name="password_confirmation" placeholder="Confirm Password"
                                                       class="form-control login-input" required
                                                       autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="row mt-4">
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-login" onclick="getRegisterDesktop();">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-2">
                        <p class="m-auto text-black mb-0">
                            <span class="mr-2">Sign up With</span>
                            <a href="{{route('Login.facebook')}}"><img src="{{asset('public/assets/images/register/4.png')}}" alt="SOCIAL LOGIN 1" class="img-fluid mr-2" /></a>
                            <a href="{{route('Login.google')}}"><img src="{{asset('public/assets/images/register/6.png')}}" alt="SOCIAL LOGIN 3" class="img-fluid mr-2" /></a>
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
    <!--For mobile-->
     <section class="pt-20 pb-20 bg-login d-md-none">
        <div class="container">
            <div class="row">
               <div class="col-md-6 pt-4 pb-4">
                    <div class=" align-items-center">
                        <div class="m-auto login-form_Mob">
                            <div class="pt-4 pb-3 text-white text-center login-form-heading">
                                SIGN UP
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @error('name')
                                    <div class="alert alert-danger ml-3 mr-3 mt-3 mb-0 p-2 fs-13">
                                        {{ $message }}
                                    </div>
                                    @enderror
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
                            <form method="POST" action="{{ route('register') }}" id="mobile-register-form">
                                @csrf
                                <input type="hidden" name="" id="response-mobile">
                                <div class="p-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-name ltn__custom-icon">
                                                <input type="text" id="first_name" name="first_name" placeholder="First Name"
                                                       class="form-control login-input  @error('first_name') is-invalid @enderror"
                                                       value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-name ltn__custom-icon">
                                                <input type="text" id="last_name" name="last_name" placeholder="Last Name"
                                                       class="form-control login-input  @error('last_name') is-invalid @enderror"
                                                       value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-email ltn__custom-icon">
                                                <input type="email" id="email" name="email" placeholder="Email ID"
                                                       class="form-control login-input @error('email') is-invalid @enderror"
                                                       value="{{ old('email') }}" required autocomplete="email"
                                                       autofocus>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-password ltn__custom-icon">
                                                <input type="password" id="password" name="password"
                                                       placeholder="Password"
                                                       class="form-control login-input @error('password') is-invalid @enderror"
                                                       required autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="input-item input-item-password ltn__custom-icon">
                                                <input type="password" id="password-confirm"
                                                       name="password_confirmation" placeholder="Confirm Password"
                                                       class="form-control login-input" required
                                                       autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-login log_reg" onclick="getRegisterMobile();">
                                                {{ __('Register') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                   <div class="d-flex align-items-center mt-2">
                       <p class="m-auto text-black mb-0">
                           <span class="mr-2">Sign up With</span>
                           <a href="{{route('Login.facebook')}}"><img src="{{asset('public/assets/images/register/4.png')}}" alt="SOCIAL LOGIN 1" class="img-fluid mr-2" /></a>
                           <a href="{{route('Login.google')}}"><img src="{{asset('public/assets/images/register/6.png')}}" alt="SOCIAL LOGIN 3" class="img-fluid mr-2" /></a>

                       </p>
                   </div>
                </div>
                 <div class="col-md-6 pt-4 pb-4 border-right-login">
                    <div class="d-flex align-items-center h-100">
                        <div class="m-auto">
                            <img src="{{asset('public/assets/images/register/1.png')}}" alt="REGISTER 1" class="img-fluid-Mob mb-3">
                            <img src="{{asset('public/assets/images/register/2.png')}}" alt="REGISTER 1" class="img-fluid-Mob mb-3">
                            <img src="{{asset('public/assets/images/register/3.png')}}" alt="REGISTER 1" class="img-fluid-Mob mb-3">
                            <p class="text-custom-primary fw-600 fs-x-large line-height-1-3 mb-0"><em>You’re in safe zone, so browse
                                    & shop confidently</em></p>
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
        function getRegisterDesktop()
        {
            grecaptcha.ready(function(){
                grecaptcha.execute('6LcUceMfAAAAACPs5b7QopMRLfY2CeRZI37yIf94',{ action: "submit" }).then(function(token){
                  if(token){
                      document.getElementById('response').value=token;
                      $("#desktop-register-form").submit();
                  }
                })
            });
        }
		
        function getRegisterMobile()
        {
            grecaptcha.ready(function(){
                grecaptcha.execute('6LcUceMfAAAAACPs5b7QopMRLfY2CeRZI37yIf94',{ action: "submit" }).then(function(token){
                  if(token){
                      document.getElementById('response-mobile').value=token;
                      $("#mobile-register-form").submit();
                  }
                })
            });
        }      
    </script>
@endsection
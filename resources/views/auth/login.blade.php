@extends('layouts/fullLayoutMaster')

@section('title', 'Login Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
@endsection

@section('content')

  <div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner py-2">
      <!-- Login v1 -->
      <div class="card mb-0">

        <div class="card-body">
          <a href="javascript:void(0);" class="brand-logo">
            <img id="logoImg"  style="width: 180px; height: 50px" src="{{asset('images/logo/light.png')}}" >
          </a>

          <h4 class="card-title mb-1">@lang('data.Welcome to i3tmd!') 👋</h4>
          <p class="card-text mb-2">@lang('data.Please sign-in to your account and start the adventure')</p>
          @include('content.alerts.success')
          @include('content.alerts.errors')

          @if(Session::get('from_forgot_password'))
          <div style="border: 1px solid #3ab73a; text-align:center; border-radius: 10px;">
            <span>{{Session::get('from_forgot_password')}}</span>
          </div>
          @endif

          <form class="auth-login-form mt-2" action="{{ route('login.do') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="login-email" class="form-label">@lang('data.Email')</label>
              <input
                      type="text"
                      class="form-control"
                      id="login-email"
                      name="email"
                      placeholder="john@example.com"
                      aria-describedby="login-email"
                      tabindex="1"
                      autofocus
              />
            </div>

            <div class="form-group">
              <div class="d-flex justify-content-between">
                <label for="login-password">@lang('data.Password')</label>
                <a href="{{ route('reset-password') }}">
                  <small>@lang('data.Forgot Password?')</small>
                </a>
              </div>
              <div class="input-group input-group-merge form-password-toggle">
                <input
                        type="password"
                        class="form-control form-control-merge"
                        id="login-password"
                        name="password"
                        tabindex="2"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="login-password"
                />
                <div class="input-group-append">
                  <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                </div>

              </div>
            </div>
            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" name="remember_me" id="remember-me" tabindex="3" />
                <label class="custom-control-label" for="remember-me"> @lang('data.Remember Me') </label>
              </div>
            </div>
            <button class="btn btn-primary btn-block" tabindex="4">@lang('data.Sign in')</button>
          </form>
          
          <div style="padding:10px 0 0 0">
                    <p style="text-align:center">-- @lang('data.OR') --</p>
              <a class="btn btn-primary btn-block"
                 style="background-color:#4867aa !important;"
                 href="{{ route('socialite.login', 'facebook') }}"
                 tabindex="4">@lang('data.sign_facebook') <i class="fab fa-facebook"></i></a>
              <a class="btn btn-danger btn-block"
                 href="{{ route('socialite.login', 'google') }}"
                 tabindex="4">@lang('data.sign_google') <i class="fab fa-google"></i></a>
              <a class="btn btn-dark btn-block"
                 href="{{ route('socialite.login', 'twitter') }}"
                 tabindex="4">@lang('data.sign_twitter') <i class="fab fa-twitter"></i></a>
          </div>

          <p class="text-center mt-2">
            <span>@lang('data.New on our platform?')</span>
            <a href="{{ route('register') }}">
              <span>@lang('data.Create an account')</span>
            </a>
          </p>

        </div>
      </div>
      <!-- /Login v1 -->
    </div>
  </div>
@endsection

@section('vendor-script')
  <script src="{{asset(mix('vendors/js/forms/validation/jquery.validate.min.js'))}}"></script>
@endsection

@section('page-script')
  <script src="{{asset(mix('js/scripts/pages/page-auth-login.js'))}}"></script>
@endsection

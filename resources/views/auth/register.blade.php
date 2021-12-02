
@extends('layouts/fullLayoutMaster')

@section('title', 'Register Page')

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/page-auth.css')) }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
  {{-- Page JS --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@endsection


@section('content')
<div class="auth-wrapper auth-v1 px-2">
  <div class="auth-inner py-2">
    <!-- Register v1 -->
    <div class="card mb-0">
      <div class="card-body">
        @include('content.alerts.success')
        @include('content.alerts.errors')
        <a href="javascript:void(0);" class="brand-logo">
          <img style="width: 180px; height: 50px" src="{{asset('images/logo/light.png')}}" >
        </a>

        <h4 class="card-title mb-1">@lang('data.Adventure starts here') 🚀</h4>
        <p class="card-text mb-2">@lang('data.Sell your game account using i3tmd!')</p>

        <form class="auth-register-form mt-2" action="{{ route('register.do') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="register-name" class="form-label">@lang('data.Full name')</label>
            <input
                    type="text"
                    class="form-control"
                    id="register-name"
                    name="name"
                    placeholder="Khaled Samir"
                    aria-describedby="register-username"
                    tabindex="1"
                    autofocus
            />
          </div>
          @error("name")
          <span class="text-danger">{{$message}}</span>
          @enderror
          <div class="form-group">
            <label for="register-username" class="form-label">@lang('data.Username')</label>
            <input
              type="text"
              class="form-control"
              id="register-username"
              name="username"
              placeholder="i3tmd"
              aria-describedby="register-username"
              tabindex="1"
              autofocus
              onkeyup="if (/[^|a-z0-9_]+/g.test(this.value)) this.value = this.value.replace(/[^|a-z0-9_]+/g,'')"

            />
          </div>
          @error("username")
          <span class="text-danger">{{$message}}</span>
          @enderror
          <div class="form-group">
            <label for="register-mobile" class="form-label">@lang('data.Mobile')</label><br>
            <input
                    type="tel"
                    class="form-control"
                    id="register_mobile"
                    name="register-mobile"
                    placeholder=""
                    aria-describedby="register-mobile"
                    tabindex="2"

            />
          </div>
          <input type="hidden" id="country" name="country"/>
          @error("mobile")
          <span class="text-danger">{{$message}}</span>
          @enderror
          <p id="output">@lang('data.Please enter a valid number below')</p>

          <div class="form-group">
            <label for="role" class="form-label">@lang('data.Role')</label><br>
            <input type="radio" id="vendor" name="role" value="Vendor">
            <label for="vendor">{{__('data.Vendor')}}</label><br>
            <input type="radio" id="member" name="role" value="Member">
            <label for="member">{{__('data.Member')}}</label><br>
          </div>
          @error("role")
          <span class="text-danger">{{$message}}</span>
          @enderror
          <script>
            window.addEventListener('load',()=>{
              document.querySelector('#register_mobile').parentElement.style.width = '100%';
            })

             var country = $('#country');

            var inp =$('#register_mobile');
            let iti = window.intlTelInput(inp.get(0), {
              initialCountry:"sa",
              hiddenInput: "mobile",
              separateDialCode:true,

              utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.js",
            });
            country.val(iti.getSelectedCountryData().iso2);

            inp.on('countrychange', function(e) {
              // change the hidden input value to the selected country code
              country.val(iti.getSelectedCountryData().iso2);
            });

            let handleChange = function() {
              var text = (iti.isValidNumber()) ? "Correct" : 'Not correct';
              var textNode = document.createTextNode(text);
              output.innerHTML = "";
              output.appendChild(textNode);
            };

            // listen to "keyup", but also "change" to update when the user selects a country
            inp.addEventListener('change', handleChange);
            inp.addEventListener('keyup', handleChange);
          </script>




          <div class="form-group">
            <label for="register-email" class="form-label">@lang('data.Email')</label>
            <input
              type="text"
              class="form-control"
              id="register-email"
              name="email"
              placeholder="john@example.com"
              aria-describedby="register-email"
              tabindex="2"
            />
          </div>
          @error("email")
          <span class="text-danger">{{$message}}</span>
          @enderror
          <div class="form-group">
            <label for="register-password" class="form-label">@lang('data.Password')</label>

            <div class="input-group input-group-merge form-password-toggle">
              <input
                type="password"
                class="form-control form-control-merge"
                id="register-password"
                name="password"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="register-password"
                tabindex="3"
              />
              <div class="input-group-append">
                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
              </div>
            </div>
            @error("password")
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" type="checkbox" id="register-privacy-policy" tabindex="4" />
              <label class="custom-control-label" for="register-privacy-policy">
                @lang('data.I agree to') <a target="_blank" href="{{ asset('uploads/pdf/Terms&Privacy.pdf') }}">@lang('data.privacy policy & terms')</a>
              </label>
            </div>
          </div>
          <button class="btn btn-primary btn-block" tabindex="5">@lang('data.Sign up')</button>
        </form>

        <p class="text-center mt-2">
          <span>@lang('data.Already have an account?')</span>
          <a href="{{route('login')}}">
            <span>@lang('data.Sign in instead')</span>
          </a>
        </p>

      </div>
    </div>
    <!-- /Register v1 -->
  </div>
</div>
@endsection

@section('vendor-script')
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
@endsection

@section('page-script')
<script src="{{asset('js/scripts/pages/page-auth-register.js')}}"></script>
@endsection

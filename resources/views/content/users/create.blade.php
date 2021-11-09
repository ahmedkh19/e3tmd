@extends('layouts/contentLayoutMaster')

@section('title', 'Add User')

@section('vendor-style')
  {{-- Vendor Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')
  {{-- Page Css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-user.css')) }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">

  {{-- Page JS --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@endsection

@section('content')
<!-- users edit start -->
<section class="app-user-edit">
  <div class="card">
    <div class="card-body">
      @include('content.alerts.success')
      @include('content.alerts.errors')
      <ul class="nav nav-pills" role="tablist">
        <li class="nav-item">
          <a
            class="nav-link d-flex align-items-center active"
            id="account-tab"
            data-toggle="tab"
            href="#account"
            aria-controls="account"
            role="tab"
            aria-selected="true"
          >
            <i data-feather="user"></i><span class="d-none d-sm-block">@lang('data.Account')</span>
          </a>
        </li>
      </ul>
      <div class="tab-content">
        <!-- Account Tab starts -->
        <div class="tab-pane active" id="account" aria-labelledby="account-tab" role="tabpanel">
          <!-- users edit media object start -->
          <form class="form-validate" enctype="multipart/form-data" method="POST" action="{{ route('users.store') }}">
          @csrf
          <div class="media mb-2">
            <img
              src="{{asset('/uploads/images/avatars/user.jpg')}}"
              alt="users avatar"
              class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer"
              height="90"
              width="90"
            />
            <div class="media-body mt-50">
              <h4>@lang('data.Avatar')</h4>
              <div class="col-12 d-flex mt-1 px-0">
                <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                  <span class="d-none d-sm-block">@lang('data.Change')</span>
                  <input
                    class="form-control"
                    type="file"
                    id="change-picture"
                    hidden
                    accept="image/png, image/jpeg, image/jpg"
                    name="avatar"
                  />
                  <span class="d-block d-sm-none">
                    <i class="mr-0" data-feather="edit"></i>
                  </span>
                </label>
              </div>
            </div>
          </div>
          <div class="media mb-2">
            <img
              src="{{asset('/front/assets/img/bg/bg_a.jpg')}}"
              alt="Background image"
              class="users-avatar-shadow rounded mr-2 my-25"
              height="90"
              width="150"
              id="cover-img"
            />
            <div class="media-body mt-50">
              <h4>Cover</h4>
              <div class="col-12 d-flex mt-1 px-0">
                <label class="btn btn-primary mr-75 mb-0" for="change-cover">
                  <span class="d-none d-sm-block">@lang('data.Change')</span>
                  <input
                    class="form-control"
                    type="file"
                    id="change-cover"
                    hidden
                    accept="image/png, image/jpeg, image/jpg"
                    name="cover"
                  />
                  <span class="d-block d-sm-none">
                    <i class="mr-0" data-feather="edit"></i>
                  </span>
                </label>
              </div>
            </div>
          </div>
          <script>
              var cover = document.getElementById("change-cover");
              var cover_img = document.getElementById("cover-img");
              cover.addEventListener("change", function() {
                  const [file] = cover.files;
                  if (file) {
                      cover_img.src = URL.createObjectURL(file);
                  } else {
                      cover_img.src = "{{asset('/front/assets/img/bg/bg_a.jpg')}}";
                  }
              });
          </script>
          <!-- users edit media object ends -->
          <!-- users edit account form start -->
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="username">@lang('data.Username')</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="eleanor.aguilar"
                    value="{{old('username')}}"
                    name="username"
                    id="username"
                    onkeyup="if (/[^|a-z0-9_]+/g.test(this.value)) this.value = this.value.replace(/[^|a-z0-9_]+/g,'')"
                  />
                </div>
                @error("username")
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="name">@lang('data.Name')</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Eleanor Aguilar"
                    value="{{old('name')}}"
                    name="name"
                    id="name"
                  />

                </div>
                @error("name")
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="email">@lang('data.Email')</label>
                  <input
                    type="email"
                    class="form-control"
                    placeholder="ahmed@i3tmd.com"
                    value="{{old('email')}}"
                    name="email"
                    id="email"
                  />

                </div>
                @error("email")
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="col-md-4">
              <div class="form-group">
                <label for="register-mobile" class="form-label">@lang('data.Mobile')</label><br>
                <input
                        type="tel"
                        class="form-control"
                        id="register_mobile"
                        name="mobile"
                        value=""
                        placeholder=""
                        aria-describedby="register-mobile"
                        tabindex="2"

                />
              </div>
                <p id="output">@lang('data.Please enter a valid number below')</p>
                <input type="hidden" id="country" name="country"/>
                @error("mobile")
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

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


              <div class="col-md-4">
                <div class="form-group">
                  <label for="email">@lang('data.Password')</label>
                  <input
                          type="password"
                          class="form-control form-control-merge"
                          id="password"
                          name="password"
                          tabindex="2"
                          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                          aria-describedby="password"
                  />

                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="status">@lang('data.Status')</label>
                  <select class="form-control" name="status" id="status">
                    <option value="1">@lang('data.Active')</option>
                    <option value="2">@lang('data.inActive')</option>
                  </select>

                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="role">@lang('data.Role')</label>
                  {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                </div>
              </div>
              <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">@lang('data.Add User')</button>
                <button type="reset" class="btn btn-outline-secondary">@lang('data.Reset')</button>
              </div>
            </div>
          </form>
          <!-- users edit account form ends -->
        </div>

      </div>
    </div>
  </div>
</section>
<!-- users edit ends -->
@endsection

@section('vendor-script')
  {{-- Vendor js files --}}
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
{{--  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>--}}
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
@endsection

@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/app-user-edit.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/components/components-navs.js')) }}"></script>
@endsection

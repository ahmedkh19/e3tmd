@extends('layouts/contentLayoutMaster')

@section('title', __('data.Add role'))

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
@endsection

@section('content')
<!-- users edit start -->
<section class="app-user-edit">
  <div class="card">
    <div class="card-body">
      @include('content.alerts.success')
      @include('content.alerts.errors')
      <div class="tab-content">
          <form class="form-validate" enctype="multipart/form-data" method="POST" action="{{ route('roles.store') }}">
          @csrf
          <!-- users edit account form start -->
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="name">@lang('data.Name')</label>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="@lang('data.Moderator')"
                    value="{{old('name')}}"
                    name="name"
                    id="name"
                  />
                  @error("name")
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
              </div>

              <!-- Permissions -->
              @include('content.roles.permissions')
              <!-- Permissions -->

              <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">@lang('data.Add role')</button>
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


@extends('layouts/contentLayoutMaster')

@section('title', __('data.Main categories') )

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection

@section('content')

  @include('content.alerts.success')
  @include('content.alerts.errors')

  <div class="card-content collapse show">
    <div class="card-body card-dashboard">
      <table class="table display nowrap table-striped table-bordered scroll-horizontal">
        <thead class="">
        <tr>
          <th>@lang('data.Name')</th>
          <th>@lang('data.Slug')</th>
          <th>@lang('data.Status')</th>
          <th>@lang('data.Measures')</th>
        </tr>
        </thead>
        <tbody>

        @isset($categories)
          @foreach($categories as $category)
            <tr>
              <td>{{$category -> name}}</td>
              <td>{{$category -> slug}}</td>
              <td>{{$category -> getActive()}}</td>
              <td>
                <div class="btn-group" role="group"
                     aria-label="Basic example">
                  <a href="{{route('main_categories.edit',$category -> id)}}"
                     class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">@lang('data.Edit')</a>
                  <form action="{{route('main_categories.destroy',$category -> id)}}" method="POST">
                    @method('DELETE')
                    @csrf
                     <button type="submit" class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">@lang('data.Delete')</button>
                  </form>


                </div>
              </td>
            </tr>
          @endforeach
        @endisset


        </tbody>
      </table>
      {{ $categories->links() }}

      <div class="justify-content-center d-flex">
      </div>

    </div>
  </div>

@endsection

@section('vendor-script')
  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
@endsection

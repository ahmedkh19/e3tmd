
@extends('layouts/contentLayoutMaster')

@section('title', __('data.Sub categories') )

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
      <table class="table display nowrap table-striped table-bordered scroll-horizontal dataTable">
        <thead class="">
        <tr>
          <th>@lang('data.Name')</th>
          <th>@lang('data.Slug')</th>
          <th>@lang('data.Belong to')</th>
          <th>@lang('data.Status')</th>
          <th>@lang('data.Measures')</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
      </table>

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
  <script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script>

  <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>



  <script>
    $(document).ready( function () {
      $('.dataTable').DataTable({
        processing: true,
        serverSide: true,
        "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/{{ LaravelLocalization::getCurrentLocaleName() }}.json"
        },
        ajax: "{{ route('sub_category-ajax') }}",
        columns: [
          {data: 'name', name: 'name'},
          {data: 'sub_slug', name: 'slug'},
          {data: 'parent_slug', name: 'belong to'},
          {data: 'is_active', name: 'is_active'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
      });
    });
  </script>

@endsection

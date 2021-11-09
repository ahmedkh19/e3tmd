
@extends('layouts/contentLayoutMaster')

@section('title', __('data.Accounts') )

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">

  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/buttons.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">

@endsection

@section('page-style')
  <!-- Page css files -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

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
          <th>@lang('data.Pricing Method')</th>
          <th>@lang('data.Viewed')</th>
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

  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.bootstrap4.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap4.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/jszip.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/pdfmake.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/vfs_fonts.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.html5.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/buttons.print.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>


@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/tables/table-datatables-basic.js')) }}"></script>

  <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>



  <script>
    function checkStatus(status) {
      if (status === 1) {
        return "{{ __('data.Active') }}";
      } else {
        return "{{__('data.inActive')}}";
      }
    }

    $(document).ready( function () {
      $('.dataTable').DataTable({
        processing: true,
        serverSide: true,
        "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/{{ LaravelLocalization::getCurrentLocaleName() }}.json"
        },
        ajax: "{{ route('products-ajax') }}",
        columns: [
          {data: 'name', name: 'name', searchable: true},
          {data: 'slug', name: 'slug', searchable: true},
          {data: 'pricing_method', name: 'pricing_method', searchable: false},
          {data: 'viewed', name: 'viewed', searchable: false},
          {data: 'status', name: 'status', searchable: false},
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        columnDefs:
                [
                  {
                    "targets": 4,
                    "data": 'status',
                    "render": function (data, type, row, meta) {
                      return checkStatus(data)
                    }
                  },
                ],
        searching: true
      });
    });
  </script>
@endsection

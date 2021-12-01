@extends('layouts/contentLayoutMaster')

@section('title', __('data.Payments & credit'))
@section('page-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">

  <style>
    .parDivClass{
      max-height:200px;
      overflow:auto;
      margin-top: 10px;
      border-radius: 5px;
      padding: 5px;
    }
    .borderSc{
      border:1px solid gray;
    }
    .parDivClass option{
      padding:4px 9px;
    }

    .parDivClass option:hover{
      background-color:#7367f0;
      cursor: pointer;
    }
    #SelectedUser{
      background: #283046;
      border-color: #7367f0;
      overflow: auto;
      max-height: 200px;
      min-height: 80px;
      display: flex;
      flex-wrap: wrap;
    }
    #SelectedUser input{
      background: rgba(115, 103, 240, 0.12) ;
      color: #7367f0 ;
      border:none;
      outline:none;
      margin:5px;
    }
    .SecParent{
      position: relative;
      width: fit-content;

    }
    .deleteX{
      position:absolute;
      right:12px;
      top:5px;
      color:#fff;
    }
    .deleteX:hover{
      color:red;
      cursor: pointer;
    }
  </style>

@endsection

@section('content')


  <!-- Dashboard Ecommerce Starts -->
  <section id="dashboard-ecommerce">
    <div class="row match-height">
      <div class="col-lg-12 col-12">
        <div class="row match-height">
          <!-- Congratulations Card -->
          <div class="col-lg-12 col-sm-12 col-12">
            @include('content.alerts.errors')

            <div class="card card-congratulations">
              <div class="card-body text-center">

                <div class="avatar avatar-xl bg-primary shadow">
                  <div class="avatar-content">
                    <i data-feather="dollar-sign" class="font-large-1"></i>
                  </div>
                </div>
                <div class="text-center">
                  <h1 class="mb-1 text-white">@lang('data.Your credit is :') <strong> {{ \App\Models\User::getBalance() }}</strong></h1>
                  @cannot('product-create')
                    <button style="height: 50px" type="button" class="btn btn-primary send" data-toggle="modal" data-target="#exampleModal">@lang('data.Add credit')</button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@lang('data.Payments & credit')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="POST" action="{{route('payments.sendPayment')}}">
                              @csrf

                              <div class="form-group col-md-12">
                                <label class="form-label">@lang('data.Amount')</label>
                                <h6>@lang('data.You have to pay at least :') {{ \App\Models\Setting::getMinAmount() }} {{currency('rs', false)}}</h6>
                                <input type="number" name="amount" class="form-control">
                              </div>
                              <div class="form-group col-md-12">
                                <img src="{{ asset("/images/payments/myfatoorah.png") }}">
                                <img style="height: 50px" src="{{ asset("/images/payments/payment_methods.png") }}">
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">@lang('data.Submit')</button>
                              </div>


                            </form>
                          </div>

                        </div>
                      </div>
                    </div>
                  @endcannot
{{--  You have to change it from cannot to can in the future --}}
                  @can('withdraw-create')
                    @if (auth()->user()->balance >= \App\Models\Setting::getMinWithdrawAmount())
                    <button style="height: 50px" type="button" class="btn btn-primary send" data-toggle="modal" data-target="#withdrawModel">@lang('data.Withdraw funds')</button>
                    <!-- Modal -->
                    <div class="modal fade" id="withdrawModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@lang('data.Withdraw funds')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form method="POST" action="{{route('payments.withdrawFunds')}}">
                              @csrf

                              <div class="form-group col-md-12">
                                <label class="form-label">@lang('data.Amount')</label>
                                <h6>@lang('data.You have to pay at least :') {{ \App\Models\Setting::getMinWithdrawAmount() }} {{currency('rs', false)}}</h6>
                                <input type="number" name="withdrawAmount" class="form-control">
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">@lang('data.Submit')</button>
                              </div>


                            </form>
                          </div>

                        </div>
                      </div>
                    </div>
                      @endif
                  @endcan
                </div>
              </div>
            </div>
          </div>
          <!--/ Congratulations Card -->

        </div>
      </div>
     </div>
  </section>
  @include('content.alerts.success')
  <div class="row">

    @can('withdraw-list')
    <div class="col-md-12">
      <h1 style="text-align: center">@lang('data.Withdraw Requests')</h1>

      <div class="card-content collapse show">
        <div class="card-body card-dashboard">
          <table class="table display nowrap table-striped table-bordered scroll-horizontal dataTable" id="withdrawRequests">
            <thead class="">
            <tr>
              <th>@lang('data.Username')</th>
              <th>@lang('data.Total')</th>
              <th>@lang('data.Completed')</th>
              <th>@lang('data.Refunded')</th>
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
    </div>
    @endcan

    <div class="col-md-12">
      <h1 style="text-align: center">Transactions</h1>
      <div class="card-content collapse show">
        <div class="card-body card-dashboard">
          <table class="table display nowrap table-striped table-bordered scroll-horizontal dataTable" id="Transactions">
            <thead class="">
            <tr>
              <th>@lang('data.Product name')</th>
              <th>@lang('data.Total')</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
          <div class="justify-content-center d-flex">
          </div>

        </div>
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
    async function withdrawDetails(id) {
      var div = document.createElement("div");
      $("#withdrawDetailsPrimary").remove();
      var settings = {
        "url": "http://127.0.0.1:8000/ar/withdrawFunds/detailsAjax/" + id,
        "method": "GET",
        "timeout": 0,
        dataType: "json"
      };
      div.innerHTML =
              ` <div id="withdrawDetailsPrimary">
                          <button style="height: 50px" type="button" class="btn btn-primary send" data-toggle="modal" data-target="#withdrawDetailsModel">@lang('data.Withdraw funds')</button>

                    <div class="modal fade" id="withdrawDetailsModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Withdraw funds</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
      <div class="form-group col-md-12">
        <label class="form-label">{{ __('data.Full name') }}</label>
                                <input disabled id="full_name" value="" class="form-control">
                              </div>

                                    <div class="form-group col-md-12">
        <label class="form-label">{{ __('data.Bank name') }}</label>
                                <input disabled id="bank" value="" class="form-control">
                              </div>

                                    <div class="form-group col-md-12">
        <label class="form-label">{{ __('data.IBAN Number') }}</label>
                                <input disabled id="iban_number" value="" class="form-control">
                              </div>

                          </div>

                        </div>
                      </div>
                    </div>
                    </div>`
      $.ajax(settings).done(function (response) {
        $("#full_name").val(response.full_name);
        $("#bank").val(response.bank);
        $("#iban_number").val(response.iban_number);
      });
      document.body.appendChild(div);
    }

    // Transaction
    $(document).ready( function () {
      $('#Transactions').DataTable({
        processing: true,
        serverSide: true,
        "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/{{ LaravelLocalization::getCurrentLocaleName() }}.json"
        },
        ajax: "{{ route('payments.transactionsAjax') }}",
        columns: [
          {data: 'product_name', name: 'product_name', orderable: true, searchable: true},
          {data: 'amount', name: 'total',  searchable: true},
        ]
      });
    });

    // Withdraw Requests


    $(document).ready( function () {
      $('#withdrawRequests').DataTable({
        processing: true,
        serverSide: true,
        "language": {
          "url": "https://cdn.datatables.net/plug-ins/1.10.25/i18n/{{ LaravelLocalization::getCurrentLocaleName() }}.json"
        },
        ajax: "{{ route('payments.withdrawRequestsAjax') }}",
        columns: [
          {data: 'username', name: 'username', searchable: true},
          {data: 'amount', name: 'total', searchable: true},
          {data: 'isCompleted', name: 'isCompleted', searchable: false},
          {data: 'isRefunded', name: 'isRefunded', searchable: false},
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        searching: true
      });
    });

  </script>

@endsection
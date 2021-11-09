@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Ecommerce')

@section('vendor-style')
  {{-- vendor css files --}}
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/datatables.min.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap.min.css')) }}">
@endsection
@section('page-style')
  {{-- Page css files --}}
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/dashboard-ecommerce.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/pages/app-invoice-list.css')) }}">
@endsection

@section('content')
<!-- Dashboard Ecommerce Starts -->
<section id="dashboard-ecommerce">
  <div class="row match-height">
    <!-- Statistics Card -->
    <div class="col-xl-12 col-md-12 col-12">
      <div class="card card-statistics">
        <div class="card-header">
          <h4 class="card-title">@lang('data.Statistics')</h4>
          <div class="d-flex align-items-center">
            <p class="card-text font-small-2 mr-25 mb-0">Updated 1 month ago</p>
          </div>
        </div>
        <div class="card-body statistics-body">
          <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
              <div class="media">
                <div class="avatar bg-light-primary mr-2">
                  <div class="avatar-content">
                    <i data-feather="trending-up" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">230k</h4>
                  <p class="card-text font-small-3 mb-0">@lang('data.Sales')</p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
              <div class="media">
                <div class="avatar bg-light-info mr-2">
                  <div class="avatar-content">
                    <i data-feather="user" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">8.549k</h4>
                  <p class="card-text font-small-3 mb-0">@lang('data.Customers')</p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
              <div class="media">
                <div class="avatar bg-light-danger mr-2">
                  <div class="avatar-content">
                    <i data-feather="box" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">1.423k</h4>
                  <p class="card-text font-small-3 mb-0">@lang('data.Products')</p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
              <div class="media">
                <div class="avatar bg-light-success mr-2">
                  <div class="avatar-content">
                    <i data-feather="dollar-sign" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">$9745</h4>
                  <p class="card-text font-small-3 mb-0">@lang('data.Revenue')</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Statistics Card -->
  </div>

  <div class="row match-height">
    <div class="col-lg-4 col-12">
      <div class="row match-height">

        <!-- Congratulations Card -->
        <div class="col-lg-12 col-sm-12 col-12">
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


              </div>
            </div>
          </div>
        </div>
        <!--/ Congratulations Card -->

        <!-- Orders Chart Card starts -->
        <div class="col-lg-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-header flex-column align-items-start pb-0">
              <div class="avatar bg-light-primary p-50 m-0">
                <div class="avatar-content">
                  <i data-feather="users" class="font-medium-5"></i>
                </div>
              </div>
              <h2 class="font-weight-bolder mt-1">92.6k</h2>
              <p class="card-text">Orders</p>
            </div>
            <div id="gained-chart"></div>
          </div>
        </div>
        <!-- Orders Chart Card ends -->

      </div>
    </div>

    <!-- Revenue Card -->
    <div class="col-lg-8 col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">@lang('data.Revenue')</h4>
          <i data-feather="settings" class="font-medium-3 text-muted cursor-pointer"></i>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-start mb-3">
            <div class="mr-2">
              <p class="card-text mb-50">@lang('data.This Month')</p>
              <h3 class="font-weight-bolder">
                <sup class="font-medium-1 font-weight-bold">$</sup>
                <span class="text-primary">86,589</span>
              </h3>
            </div>
            <div>
              <p class="card-text mb-50">@lang('data.Last Month')</p>
              <h3 class="font-weight-bolder">
                <sup class="font-medium-1 font-weight-bold">$</sup>
                <span>73,683</span>
              </h3>
            </div>
          </div>
          <div id="revenue-chart"></div>
        </div>
      </div>
    </div>
    <!--/ Revenue Card -->

  </div>


</section>
<!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-script')
  {{-- vendor files --}}
  <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
{{--  <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>--}}
@endsection
@section('page-script')
  {{-- Page js files --}}
  <script src="{{ asset(mix('js/scripts/pages/dashboard-ecommerce.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/cards/card-analytics.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/dashboard-analytics.js')) }}"></script>
  <script src="{{ asset(mix('js/scripts/pages/app-invoice-list.js')) }}"></script>
@endsection

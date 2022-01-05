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
  @if (Auth::user()->roles_name[0] == "Vendor" || Auth::user()->roles_name[0] == "Owner")
    <!-- Statistics Card -->
    <div class="col-xl-12 col-md-12 col-12">
      <div class="card card-statistics">
        <div class="card-header">
          <h4 class="card-title">@lang('data.Statistics')</h4>
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
                  <h4 class="font-weight-bolder mb-0">{{App\Http\Controllers\Admin\DashboardController::sales()}}</h4>
                  <p class="card-text font-small-3 mb-0">@lang('data.Sales')</p>
                </div>
              </div>
            </div>
            @if (Auth::user()->roles_name[0] == "Owner")
            <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
              <div class="media">
                <div class="avatar bg-light-info mr-2">
                  <div class="avatar-content">
                    <i data-feather="user" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">{{App\Models\User::where("roles_name","=",'["Member"]')->count()}}</h4>
                  <p class="card-text font-small-3 mb-0">@lang('data.Customers')</p>
                </div>
              </div>
            </div>
            @endif
            <div class="col-xl-3 col-sm-6 col-12">
              <div class="media">
                <div class="avatar bg-light-success mr-2">
                  <div class="avatar-content">
                    <i data-feather="dollar-sign" class="avatar-icon"></i>
                  </div>
                </div>
                <div class="media-body my-auto">
                  <h4 class="font-weight-bolder mb-0">{{App\Http\Controllers\Admin\DashboardController::Revenue()[4]}}</h4>
                  <p class="card-text font-small-3 mb-0">@lang('data.Revenue')</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ Statistics Card -->
    @endif
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


              </div>
            </div>
          </div>
        </div>
        <!--/ Congratulations Card -->

       @if (Auth::user()->roles_name[0] == "Vendor" || Auth::user()->roles_name[0] == "Owner")
        <!-- Orders Chart Card starts -->
        <div class="col-lg-12 col-sm-12 col-12">
          <div class="card">
            <div class="card-header flex-column align-items-start pb-0">
              <div class="avatar bg-light-primary p-50 m-0">
                <div class="avatar-content">
                  <i data-feather="box" class="font-medium-5"></i>
                </div>
              </div>
              <h2 class="font-weight-bolder mt-1">{{ App\Http\Controllers\Admin\DashboardController::getOrders()[0] }}</h2>
              <p class="card-text">@lang('data.Products')</p>
            </div>
            <div id="gained-chart"></div>
          </div>
        </div>
        <!-- Orders Chart Card ends -->
       @endif
      </div>
    </div>

    @if (Auth::user()->roles_name[0] == "Vendor" || Auth::user()->roles_name[0] == "Owner")
    <!-- Revenue Card -->
    <div class="col-lg-8 col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">@lang('data.Revenue')</h4>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-start mb-3">
            <div class="mr-2">
              <p class="card-text mb-50">@lang('data.This Month')</p>
              <h3 class="font-weight-bolder">
                <sup class="font-medium-1 font-weight-bold">$</sup>
                <span class="text-primary">{{App\Http\Controllers\Admin\DashboardController::Revenue()[0]}}</span>
              </h3>
            </div>
            <div>
              <p class="card-text mb-50">@lang('data.Last Month')</p>
              <h3 class="font-weight-bolder">
                <sup class="font-medium-1 font-weight-bold">$</sup>
                <span>{{App\Http\Controllers\Admin\DashboardController::Revenue()[1]}}</span>
              </h3>
            </div>
          </div>
          <div id="revenue-chart"></div>
        </div>
      </div>
    </div>
    <!--/ Revenue Card -->
    @endif
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
  
  <script>
  <?php 
      $products_week = App\Http\Controllers\Admin\DashboardController::getOrders()[1];
      $revenue_this_month = App\Http\Controllers\Admin\DashboardController::Revenue()[2];
      $revenue_last_month = App\Http\Controllers\Admin\DashboardController::Revenue()[3];
  ?>
$(window).on('load', function () {
  gainedChartOptions = {
    chart: {
      height: 100,
      type: 'area',
      toolbar: {
        show: false
      },
      sparkline: {
        enabled: true
      }
    },
    colors: [window.colors.solid.primary],
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'smooth',
      width: 2.5
    },
    fill: {
      type: 'gradient',
      gradient: {
        shadeIntensity: 0.9,
        opacityFrom: 0.7,
        opacityTo: 0.5,
        stops: [0, 80, 100]
      }
    },
    series: [
      {
        name: 'Accounts',
        data: [{{$products_week[0]}}, {{$products_week[1]}}, {{$products_week[2]}}, {{$products_week[3]}}, {{$products_week[4]}}, {{$products_week[5]}}, {{$products_week[6]}}]
      }
    ],
    yaxis: [
      {
        y: 0,
        offsetX: 0,
        offsetY: 0,
        padding: { left: 0, right: 0 }
      }
    ],
    tooltip: {
      x: { show: false }
    }
  };
  gainedChart = new ApexCharts(document.querySelector('#gained-chart'), gainedChartOptions);
  gainedChart.render();

  revenueChartOptions = {
    chart: {
      height: 240,
      toolbar: { show: false },
      zoom: { enabled: false },
      type: 'line',
      offsetX: -10
    },
    stroke: {
      curve: 'smooth',
      dashArray: [0, 12],
      width: [4, 3]
    },
    grid: {
      borderColor: '#e7eef7'
    },
    legend: {
      show: false
    },
    colors: ['#d0ccff', '#ebe9f1'],
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        inverseColors: false,
        gradientToColors: [window.colors.solid.primary, '#ebe9f1'],
        shadeIntensity: 1,
        type: 'horizontal',
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100, 100, 100]
      }
    },
    markers: {
      size: 0,
      hover: {
        size: 5
      }
    },
    xaxis: {
      labels: {
        style: {
          colors: '#b9b9c3',
          fontSize: '1rem'
        }
      },
      axisTicks: {
        show: false
      },
      categories: ['1','5','9','13','17','21','26','31'],
      axisBorder: {
        show: false
      },
      tickPlacement: 'on'
    },
    yaxis: {
      tickAmount: 5,
      labels: {
        style: {
          colors: '#b9b9c3',
          fontSize: '1rem'
        },
        formatter: function (val) {
          return val > 999 ? (val / 1000).toFixed(0) + 'k' : val;
        }
      }
    },
    grid: {
      padding: {
        top: -20,
        bottom: -10,
        left: 20
      }
    },
    tooltip: {
      x: { show: false }
    },
    series: [
      {
        name: 'This Month',
        data: [{{$revenue_this_month[0]}},{{$revenue_this_month[1]}},{{$revenue_this_month[2]}},{{$revenue_this_month[3]}},{{$revenue_this_month[4]}},{{$revenue_this_month[5]}},{{$revenue_this_month[6]}},{{$revenue_this_month[7]}}]
      },
      {
        name: 'Last Month',
        data: [{{$revenue_last_month[0]}},{{$revenue_last_month[1]}},{{$revenue_last_month[2]}},{{$revenue_last_month[3]}},{{$revenue_last_month[4]}},{{$revenue_last_month[5]}},{{$revenue_last_month[6]}},{{$revenue_last_month[7]}}]
      }
    ]
  };
  revenueChart = new ApexCharts(document.querySelector('#revenue-chart'), revenueChartOptions);
  revenueChart.render();

});

  </script>
  <script src="{{ asset(mix('js/scripts/pages/app-invoice-list.js')) }}"></script>
@endsection

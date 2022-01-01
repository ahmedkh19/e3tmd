
@extends('layouts/contentLayoutMaster')
@php
  $titleLang = __('data.Add new account');
  use \App\Models\Setting;
@endphp
@section('title',  $titleLang)

@section('vendor-style')
  <!-- vendor css files -->
  <style>
    .thumbnail {
      height: 100px;
      width: 100px;
      margin : 20px
    }
  </style>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.css">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/wizard/bs-stepper.min.css')) }}">
  <link rel="stylesheet" type="text/css" href="{{asset('css/base/pages/page-pricing.css')}}">
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('page-style')
  <!-- Page css files -->
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">
@endsection

@section('content')
  <!-- Horizontal Wizard -->
  <!--Ahmed Khan ...........here main form -->
  <section class="horizontal-wizard" >
    <div class="bs-stepper horizontal-wizard-example">
      <!--bs-stepper-header start-->
      @include('content.alerts.success')
      @include('content.alerts.errors')
      <div class="bs-stepper-header">
        <div class="step" data-target="#account-details">
          <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            1
          </span>
            <span class="bs-stepper-label">
            <span class="bs-stepper-title">@lang('data.General Information')</span>
            <span class="bs-stepper-subtitle">@lang('data.Account Details')</span>
          </span>
          </button>
        </div>
        <div class="line">
          <i data-feather="chevron-right" class="font-medium-2"></i>
        </div>
        <div class="step" data-target="#personal-info">
          <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
              2
          </span>
            <span class="bs-stepper-label">
            <span class="bs-stepper-title">@lang('data.Price & Auction')</span>
            <span class="bs-stepper-subtitle">@lang('data.Enter the price or enable the Auction')</span>
          </span>
          </button>
        </div>
        <div class="line">
          <i data-feather="chevron-right" class="font-medium-2"></i>
        </div>
        <div class="step" data-target="#address-step">
          <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            3
          </span>
            <span class="bs-stepper-label">
            <span class="bs-stepper-title">@lang('data.The Package')</span>
            <span class="bs-stepper-subtitle">@lang('data.Choose the package that suits you')</span>
          </span>
          </button>
        </div>
{{--
        <div class="line">
          <i data-feather="chevron-right" class="font-medium-2"></i>
        </div>
        <div class="step" data-target="#social-links">
          <button type="button" class="step-trigger">
          <span class="bs-stepper-box">
            4
          </span>
            <span class="bs-stepper-label">
            <span class="bs-stepper-title">@lang('data.Account Data(Optional)')</span>
            <span class="bs-stepper-subtitle">@lang('data.Add your account data')</span>
          </span>
          </button>
        </div>
--}}
      </div>
      <!--bs-stepper-header end-->

      <form class="bs-stepper-content" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="account-details" class="content">
          <div class="content-header">
            <h5 class="mb-0">@lang('data.Account Details')</h5>
            <small class="text-muted">@lang('data.Enter Your Account Details.')</small>
          </div>

          <!--form-->
          <info enctype="multipart/form-data">
            <div class="row">
              <div class="form-group col-md-12">
                <label class="form-label" for="name">@lang('data.Account Title') *</label>
                <input value="{{ old('name') }}"
                       type="text" name="name" id="name" class="form-control" placeholder="@lang('Fortnite full access account | level 100')" />
                @error("name")
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group col-md-12">
                <label class="form-label" for="short_description">@lang('data.Account short description')</label>
                <textarea class="form-control" id="short_description" name="short_description" spellcheck="false" placeholder="@lang('data.Account short description')">{{ old('short_description') }}</textarea>
                @error("short_description")
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="form-group col-md-12">
                <label class="form-label" for="description">@lang('data.Account description') *</label>
                <textarea rows="5" class="form-control" id="description" name="description" spellcheck="false" placeholder="@lang('data.Account description')">{{ old('description') }}</textarea>
                @error("description")
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              
              <div class="form-group col-md-12">
                <p>OS: </p>
                <label><input type="checkbox" name="os[]" value="p"> Playstation</label>
                <label><input type="checkbox" name="os[]" value="x"> Xbox</label>
                <label><input type="checkbox" name="os[]" value="s"> Smartphone</label>
              </div>

              <div class="form-group col-md-12">
                <label class="form-label" for="description">@lang('data.Account Categories') *</label>
                <select name="categories[]" onchange="myFunction()" id="AccountCategories" class="select2 form-control" multiple>
                  <optgroup label="@lang('data.Please Select a category')">
                    @if($categories && $categories->count() > 0)
                      @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                      @endforeach
                    @endif
                  </optgroup>
                </select>
                @error("categories")
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>

              <div class="form-group col-md-12" id="parentAccountCategoriesSub">
                <label class="form-label" for="description">Account Sub Categories</label>
                <select id="AccountCategoriesSub" name="sub_categories[]" class="select2 form-control" multiple>
                  <!-- <option value="id" > slug </option> -->
                </select>
              </div>

              <script>
                let data = [];
                let AccountCategoriesSub = document.getElementById("AccountCategoriesSub");
                let parentAccountCategoriesSub = document.getElementById("parentAccountCategoriesSub");
                let AccountCategoriesValue = document.getElementById("AccountCategories");
                parentAccountCategoriesSub.classList.add('d-none');
                function myFunction() {
                  const API_URL = `{{ URL("/api/sub_categories/") }}/`+ $("#AccountCategories").val();
                  const XHR = new XMLHttpRequest();
                  XHR.open(`GET`, API_URL);
                  XHR.send();

                  //checking
                  XHR.onreadystatechange = ()=>{
                    if(XHR.readyState === 4 && XHR.status === 200){
                      parentAccountCategoriesSub.classList.remove('d-none');
                      data = JSON.parse(XHR.response);
                      data.forEach(element => {
                        let option = document.createElement("option");
                        option.textContent  = element.slug
                        option.setAttribute("id", element.id);
                        option.setAttribute("value", element.id);
                        if (!AccountCategoriesSub.querySelector("option[value='"+element.id+"']")) {
                            AccountCategoriesSub.appendChild(option);
                        }
                      });
                    }
                  }
                }
              </script>
              
              <div class="form-group col-md-12">
                  <p>{{__('data.Featured Image')}} *</p>
                  <span id="delete_main_image" style="font-size: 20px;top: 19px;position: absolute;left:0;background-color: red;border-radius:18px;padding: 0px 8px 2px 8px;cursor: pointer" class="hidden">x</span>
                  <label class="w-44 flex flex-col items-center px-5 py-5 bg-white-rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer">
                      <span id="FORMSpan">اختر صورة</span>
                      <img id="FORMActuallImage" src="" style="width:300px;" class="hidden">
                      <input id="FORMImage" type="file" name="main_image" accept=".jpg, .jpeg, .png" class="hidden">
                  </label>
                  @error("main_image")
                  <span class="text-danger">{{$message}}</span>
                  @enderror
              </div>

              <script>
                  var FORMImage = document.getElementById('FORMImage');
                  var DeleteMainImage = document.getElementById('delete_main_image');
                  if (FORMImage) {
                      FORMImage.addEventListener("change", function() {
                        const [file] = FORMImage.files
                        if (file) {
                            FORMActuallImage.src = URL.createObjectURL(file)
                        }
                        FORMActuallImage.classList = '';
                        DeleteMainImage.classList = '';
                        FORMSpan.innerHTML = '';
                      });
                   }
                   if (DeleteMainImage) {
                       DeleteMainImage.addEventListener("click", function() {
                         FORMActuallImage.src = '';
                         FORMImage.value= "";
                         DeleteMainImage.classList.add("hidden");
                         FORMActuallImage.classList.add("hidden");
                         FORMSpan.innerHTML = 'اختر صورة';
                       });
                   }
              </script>

              <div class="form-group col-md-12">
                <p>{{__('data.Images')}}</p>
                <label class="form-label">
                    <img id="images" width="100px" style="cursor: pointer" height="100px" src="{{ asset('front/assets/img/plus.png') }}" />
                    <input id='account_images' accept=".jpg, .jpeg, .png" type='file' class="d-none" multiple />
                </label>
                <output id='images_result' class="row"></output>
                @error("images.*")
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              
              <script>
                  var AccountImages = document.getElementById('account_images');
                  var IMAGES_RESULT = document.getElementById('images_result');
                  if (AccountImages) {
                      AccountImages.addEventListener("change", function() {
                        const [file] = AccountImages.files
                        if (file) {
                            var NewDiv = document.createElement("div");
                            var NewSpan = document.createElement("span");
                            NewSpan.innerHTML = "x";
                            NewSpan.style = "position: absolute;cursor: pointer;background-color: red;padding: 1px 6px 3px 7px;border-radius: 16px;";
                            NewSpan.setAttribute("onclick","this.parentNode.remove();");
                            NewDiv.append(NewSpan);
                            var NewImage = document.createElement("img");
                            NewImage.src = URL.createObjectURL(file);
                            NewImage.classList.add("thumbnail");
                            NewDiv.append(NewImage);
                            var NewInput = document.createElement("input");
                            NewInput.name = "images[]";
                            NewInput.type = "file";
                            NewInput.setAttribute("accept","image/*");
                            NewInput.setAttribute("hidden","");
                            NewInput.files = AccountImages.files;
                            NewDiv.append(NewInput);
                            IMAGES_RESULT.append(NewDiv);
                        }
                      });
                   }
              </script>

            </div>
          </info>
          <!--form-->

          <div class="d-flex justify-content-between">
            <button class="btn btn-outline-secondary btn-prev" type="button" disabled>
              <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
              <span class="align-middle d-sm-inline-block d-none">@lang('data.Previous')</span>
            </button>
            <button class="btn btn-primary btn-next" type="button">
              <span class="align-middle d-sm-inline-block d-none">@lang('data.Next')</span>
              <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
            </button>
          </div>
        </div>

        <div id="personal-info" class="content">
          <div class="content-header">
            <h5 class="mb-0">@lang('data.Price & Auction')</h5>
            <small>@lang('data.Please choose the prefer way to sell your account')</small>
          </div>

          <!--form-->
          <info>
            <div class="row">
              <div class="form-group col-md-6">
                <script>
                    function handleAdPrice(method) {
                      var fixed_price = "{{ Setting::getAdFixedPrice() }}";
                      var auction_price = "{{ Setting::getAdAuctionPrice() }}";
                      var ad_price = fixed_price;
                      if (method == "Auction") { ad_price = auction_price; }
                      document.getElementById("ad_price_action_fixed").innerHTML = ad_price;
                      var method_desciption = " @lang('data.SAR') @lang('data.per advertisement')";
                      document.getElementById("ad_price_action_fixed_mini").innerHTML = ad_price + method_desciption; 
                    }
                </script>
                <label class="form-label" for="pricing_method">@lang('data.Pricing Method')</label>
                <select class="select2 w-100" onchange="handleAdPrice(this.value);" name="pricing_method" id="pricing_method">
                  <option label=" "></option>
                  <option value="Fixed"
                          @if (old('pricing_method') === 'Fixed') selected @endif >@lang('data.Fixed price')</option>
                  <option value="Auction"
                          @if (old('pricing_method') === 'Auction') selected @endif
                  >@lang('data.Auction')</option>
                </select>
                @error("pricing_method")
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
            </div>

            <!-- Start Auction -->
            <div id="Auction-Section">
              <div class="row">
                <div class="form-group col-md-4">
                  <label class="form-label" for="start_bid_amount">@lang('data.Bid start price')</label>
                  <input value="{{old('start_bid_amount')}}"
                         type="text" name="start_bid_amount" id="start_bid_amount" class="form-control" placeholder="" />
                  @error("start_bid_amount")
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>


                <div class="form-group col-md-3 ui calendar" id="rangestart">
                  <label class="form-label" for="auction_start">@lang('data.Auction start date')</label><br>
                  <div class="ui input left icon">
                    <input type="text"  placeholder="Date/Time" name="auction_start" id="auction_start" class="form-control"/>
                  </div>
                  @error("auction_start")
                  <span class="text-danger">{{$message}}</span>
                  @enderror

                </div>

                <div class="form-group col-md-3 ui calendar" id="rangeend">
                  <label class="form-label" for="auction_end">@lang('data.Auction end date')</label><br>
                  <div class="ui input left icon">
                    <input type="text" placeholder="Date/Time" name="auction_end" id="auction_end" class="form-control"/>
                  </div>
                  @error("auction_end")
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
              </div>
            </div>
            <!-- End Auction -->

            <!-- Start Fixed price -->
            <div id="FixedPrice-Section" >

              <div class="row">

                <div class="form-group col-md-12">
                  <label class="form-label" for="price">@lang('data.Price')</label>
                  <input  value="{{old('price')}}"
                          type="text" name="price" id="price" class="form-control" placeholder="@lang('data.Enter the price')" />
                  @error("price")
                  <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>

              </div>

            </div>
            <!-- End Fixed price -->
          </info>
          <!--form-->

          <div class="d-flex justify-content-between">
            <button class="btn btn-primary btn-prev" type="button">
              <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
              <span class="align-middle d-sm-inline-block d-none">@lang('data.Previous')</span>
            </button>

            <button class="btn btn-primary btn-next" type="button" id="Pricing_method_btn">
              <span class="align-middle d-sm-inline-block d-none">@lang('data.Next')</span>
              <i data-feather="arrow-right" class="align-middle ml-sm-25 ml-0"></i>
            </button>

          </div>
        </div>

        <div id="address-step" class="content">
          <div class="content-header">
            <h5 class="mb-0">@lang('data.Packages')</h5>
            <small>@lang('data.Choose from the packages that suit you')</small>
          </div>

          <!--form-->
          <info>
            @error("plan")
            <span class="text-danger">{{$message}}</span>
            @enderror
            <!-- pricing plan cards -->
            <div class="row pricing-card">
              <div class="col-12 col-sm-offset-2 col-sm-10 col-md-12 col-lg-offset-2 col-lg-10 mx-auto">
                <div class="row">
                  <!-- basic plan -->
                  <div class="col-12 col-md-4">
                    <div class="card basic-pricing text-center border shadow Basic_plan">
                      <div class="card-body">
                        <img src="{{asset('images/illustration/Pot1.svg')}}" class="mb-2 mt-5" alt="svg img" />
                        <h3>@lang('data.The Basic')</h3>
                        <div class="annual-plan">
                          <div class="plan-price mt-2">
                            <sup class="font-medium-1 font-weight-bold text-primary">@lang('data.Free')</sup>
                          </div>
                          <small class="annual-pricing d-none text-muted"></small>
                        </div>
                        <ul class="list-group list-group-circle text-left">
                          <li class="list-group-item">@lang('data.For Free')</li>
                          <li class="list-group-item">{{ Setting::getCommissionWithPrecent()  }} @lang('data.commission after sale')</li>
                          <li class="list-group-item">@lang('data.Follow up on the sales process')</li>
                          <li class="list-group-item">@lang('data.There is no option to request a data change before the account is handed over')</li>
                        </ul>
                        <!--Ahmed khan-->
                        <!--  d-none -->
                        <input type="text" hidden id="plan" name="plan" value="">
                        <label for="" class="btn btn-block btn-outline-success mt-2 btn_Basic_plan">select</label>
                      </div>
                    </div>
                  </div>
                  <!--/ basic plan -->

                  <!-- standard plan -->
                  <div class="col-12 col-md-4">
                    <div class="card standard-pricing border text-center standard_plan">
                      <div class="card-body">
                        <div class="pricing-badge text-right">
                          <div class="badge badge-pill badge-light-primary">@lang('data.Recommended')</div>
                        </div>
                        <img src="{{asset('images/illustration/Pot2.svg')}}" class="mb-1" alt="svg img" />
                        <h3>@lang('data.Paid')</h3>
                        <div class="annual-plan">
                          <div class="plan-price mt-2">
                            <sup class="font-medium-1 font-weight-bold text-primary">@lang('data.SAR')</sup>
                            <span class="pricing-standard-value font-weight-bolder text-primary" id="ad_price_action_fixed">{{ Setting::getAdFixedPrice() }}</span>
                          </div>
                          <small class="annual-pricing d-none text-muted"></small>
                        </div>
                        <ul class="list-group list-group-circle text-left">
                          <li class="list-group-item" id="ad_price_action_fixed_mini">{{ Setting::getAdFixedPrice() }}  @lang('data.SAR') @lang('data.per advertisement')</li>
                          <li class="list-group-item">@lang('data.No commission after sale')</li>
                          <li class="list-group-item">@lang('data.Follow up on the sales process')</li>
                          <li class="list-group-item">@lang('data.The option to request a data change before handing over the account')</li>
                        </ul>
                        <!--Ahmed khan-->
                        <label for="" class="btn btn-block btn-primary mt-2 btn_standard_plan">select</label>
                      </div>
                    </div>
                  </div>
                  <!--/ standard plan -->
                </div>
              </div>
            </div>
          </info>
          <!--form-->

          <div class="d-flex justify-content-between">
            <button class="btn btn-primary btn-prev" type="button">
              <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
              <span class="align-middle d-sm-inline-block d-none">@lang('data.Previous')</span>
            </button>
            <button class="btn btn-success ">@lang('data.Submit')</button>
          </div>
        </div>

{{--
        <div id="social-links" class="content">
          <div class="content-header">
            <h5 class="mb-0">@lang('data.Account Data(Optional)')</h5>
            <small>@lang('data.Add your account data')</small>
          </div>

          <!--form-->
          <info>
            <div class="row">
              <div class="form-group col-md-6">
                <label class="form-label" for="account_email">@lang('data.Account email')</label>
                <input
                        type="email"
                        id="account_email"
                        name="account_email"
                        class="form-control"
                        placeholder="ahmed@gmail.com"
                        value="{{old('account_email')}}"
                />
                @error("account_email")
                <span class="text-danger">{{$message}}</span>
                @enderror
              </div>
              <div class="form-group col-md-6">
                <label class="form-label" for="account_email_website">@lang('data.Email website link')</label>
                <input
                        type="text"
                        id="account_email_website"
                        name="account_email_website"
                        class="form-control"
                        placeholder="www.google.com"
                        value="{{old('account_email_website')}}"
                />
              </div>
              @error("account_email_website")
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

            <div class="row">

              <div class="form-group col-md-12">
                <label class="form-label" for="account_username">@lang('data.Account username')</label>
                <input
                        type="text"
                        id="account_username"
                        name="account_username"
                        class="form-control"
                        placeholder="i3tmd"
                        value="{{old('account_username')}}"
                />
              </div>
              @error("account_username")
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label class="form-label" for="account_password">@lang('data.Account password')</label>
                <input
                        type="password"
                        id="account_password"
                        name="account_password"
                        class="form-control"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                />
              </div>
              @error("account_password")
              <span class="text-danger">{{$message}}</span>
              @enderror
              <div class="form-group col-md-6">
                <label class="form-label" for="account_confirm_password">@lang('data.Confirm password')</label>
                <input
                        type="password"
                        id="account_confirm_password"
                        name="account_confirm_password"
                        class="form-control"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                />
              </div>
              @error("account_confirm_password")
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>

          </info>
          <!--form-->

          <div class="d-flex justify-content-between">
            <button class="btn btn-primary btn-prev" type="button">
              <i data-feather="arrow-left" class="align-middle mr-sm-25 mr-0"></i>
              <span class="align-middle d-sm-inline-block d-none">@lang('data.Previous')</span>
            </button>
            <button class="btn btn-success ">@lang('data.Submit')</button>
          </div>
        </div>
      </form>

    </div>
--}}
  </section>
  <!-- /Horizontal Wizard -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fomantic-ui@2.8.8/dist/semantic.min.js"></script>
  <script>

    $('#rangestart')
            .calendar({
              endCalendar: $('#rangeend'),
              monthFirst: false,
              ampm: false,
              formatter: {
                date: function (date, settings) {
                  if (!date) return '';
                  var day = date.getDate();
                  var month = date.getMonth() + 1;
                  var year = date.getFullYear();
                  return year+ '-' + month + '-' +day ;
                }
              }
            })
    ;

    $('#rangeend')
            .calendar({
              startCalendar: $('#rangestart'),
              monthFirst: false,
              ampm: false,
              formatter: {
                date: function (date, settings) {
                  if (!date) return '';
                  var day = date.getDate();
                  var month = date.getMonth() + 1;
                  var year = date.getFullYear();
                  return year+ '-' + month + '-' +day ;
                }
              }
            })
    ;
  </script>


@endsection

@section('vendor-script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui-calendar/0.0.8/calendar.min.js" integrity="sha512-PAbeCLn5ujGnnJa8R+Fjg3p6Dl66qXuXmmDcpfqq0uSUGZ+Qv+wogDou7uBna+f7g+F6Bm5T+Q1oSwpjxZJ3Xw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- vendor files -->
  <script src="{{ asset(mix('vendors/js/forms/wizard/bs-stepper.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
  <script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-wizard.js')) }}"></script>
  <script>

    //Date
    $('#auction_start').calendar({
      type: 'date',
      endCalendar: $('#auction_end'),
      formatter: {
        date: function (date, settings) {
          if (!date) return '';
          var day = date.getDate();
          var month = date.getMonth() + 1;
          var year = date.getFullYear();
          return day + '/' + month + '/' + year;
        }
      }
    });
    $('#auction_end').calendar({
      type: 'date',
      startCalendar: $('#auction_start'),
    });

    //btn_class
    document.querySelector('.btn_Basic_plan').addEventListener('click', ()=>{
      document.querySelector('.Basic_plan').classList.add('popular');
      document.querySelector('.Basic_plan').classList.remove('border');
      document.querySelector('.standard_plan').classList.remove('popular');
      document.querySelector('.btn_standard_plan').textContent = `select`;
      document.querySelector('.btn_Basic_plan').textContent = `selected`;

      document.querySelector('#plan').value = `Basic`;
      console.log(document.querySelector('#plan').value)

    })

    document.querySelector('.btn_standard_plan').addEventListener('click', ()=>{
      document.querySelector('.btn_standard_plan').textContent = `selected`;
      document.querySelector('.Basic_plan').classList.remove('popular');
      document.querySelector('.standard_plan').classList.add('popular');
      document.querySelector('.standard_plan').classList.remove('border');
      document.querySelector('.btn_Basic_plan').textContent = `select`;
      document.querySelector('#plan').value = `Paid`;
      console.log(document.querySelector('#plan').value)
    });


    let pricing_method = $('#pricing_method');
    let pricing_btn = $('#Pricing_method_btn');
    let Fixed = $('#FixedPrice-Section');
    let fixedPrice = $('#price');

    let Auction = $('#Auction-Section');
    let start_bid_amount = $('#start_bid_amount');
    let Auction_start = $('#auction_start');
    let Auction_end = $('#auction_end');

    Auction.hide();
    Fixed.hide();

    pricing_method.on('change', function () {
      if (pricing_method.val() === 'Auction') {
        document.querySelector('.btn_Basic_plan').classList.add('d-none');
        Auction.show();
        Fixed.hide();
      } if (pricing_method.val() === "Fixed") {
        Auction.hide();
        Fixed.show();
        document.querySelector('.btn_Basic_plan').classList.remove('d-none');
      }
    });


    // If the user pressed (Next)
    pricing_btn.click(function () {
      if (pricing_method.val() === 'Auction')
        fixedPrice.val('');
      else {
        start_bid_amount.val('');
        Auction_start.val('');
        Auction_end.val('');
      }
    });



  </script>
@endsection

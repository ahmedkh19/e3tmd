
@extends('layouts/contentLayoutMaster')

@section('title', __('data.Settings') )

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('page-style')
  <!-- Page css files -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-wizard.css')) }}">

  <style>
    img.services-image {
      height: 80px;
      width: 50%;
    }
    .thumbnail {
      height: 100px;
      width: 100px;
      margin : 20px
    }
    .remove_img {
      background-color: #a74444;
      color: white;
      border-radius: 10px;
      cursor: pointer;
      padding: 2px 7px 3px 7px;
    }
  </style>
@endsection

@section('content')

  <section id="input-group-basic">
    <div class="row">
      <!-- Basic -->
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">@lang('data.Website Settings')</h4>
          </div>
          <div class="card-body">
            @include('content.alerts.success')
            @include('content.alerts.errors')
            <form method="POST" enctype="multipart/form-data" action="{{ route('settings.update') }}">
              @method('PUT')
              @csrf
              <label for="commission_field">{{__('data.Commission')}}</label>
              <div class="input-group mb-2">
                <input
                        id="commission_field"
                        type="text"
                        name="commission"
                        class="form-control"
                        value="@if (old('commission')){{old('commission')}}@else{{$settings[0]->value}}@endif"
                        placeholder="3"
                        aria-label="commission-field"
                />
              </div>


              <label for="ad_fixed_price_field">{{ __('data.Ad Fixed price') }}</label>
              <div class="input-group mb-2">
                <input
                        id="ad_fixed_price_field"
                        type="text"
                        name="ad_fixed_price"
                        value="@if (old('ad_fixed_price')){{old('ad_fixed_price')}}@else{{$settings[1]->value}}@endif"
                        class="form-control"
                        aria-label="ad_fixed_price_field"
                />
              </div>

              <label for="ad_auction_price_field">{{ __('data.Ad Auction price') }}</label>
              <div class="input-group mb-2">
                <input
                        id="ad_auction_price_field"
                        type="text"
                        name="ad_auction_price"
                        value="@if (old('ad_auction_price')){{old('ad_auction_price')}}@else{{$settings[2]->value}}@endif"
                        class="form-control"
                        aria-label="ad_auction_price_field"
                />
              </div>

              <label for="min_amount_field">{{__('data.Minimum payment amount')}}</label>
              <div class="input-group mb-2">
                <input
                        type="text"
                        name="min_amount"
                        class="form-control"
                        placeholder="3"
                        value="@if (old('min_amount')){{old('min_amount')}}@else{{$settings[3]->value}}@endif"
                        aria-label="min_amount"
                        id="min_amount_field"
                />
              </div>

              <label for="withdraw_min_field">{{__('data.Minimum withdraw amount')}}</label>
              <div class="input-group mb-2">

                <input
                        type="text"
                        name="withdraw_min"
                        class="form-control"
                        placeholder="3"
                        value="@if (old('min_amount')){{old('min_amount')}}@else{{$settings[4]->value}}@endif"
                        aria-label="withdraw_min"
                        id="withdraw_min_field"
                />
              </div>
              <label>صور السلايدر</label>

              <div class="form-group col-md-12">
                  <label class="form-label">
                      <img id="images" width="100px" style="cursor: pointer" height="100px" src="{{ asset('front/assets/img/plus.png') }}" />
                      <input id='account_images' accept=".jpg, .jpeg, .png" type='file' class="d-none" />
                </label>

                <output id="images_result" class="row">
                                
                @foreach (json_decode($settings[5]->value) as $image)
                    <div>
                       <span class="remove_img position-absolute" onclick="this.parentNode.remove();">x</span>
                       <img src="{{ URL( 'front/assets/img/content/slider/' . $image ) }}" class="thumbnail" />
                       <input type="hidden" name="keep_images[]" value="{{ $image }}">
                    </div>
                @endforeach
                </output>
                
                @error("slider_images.*")
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
                            NewSpan.classList.add("remove_img","position-absolute");
                            NewSpan.setAttribute("onclick","this.parentNode.remove();");
                            NewDiv.append(NewSpan);
                            var NewImage = document.createElement("img");
                            NewImage.src = URL.createObjectURL(file);
                            NewImage.classList.add("thumbnail");
                            NewDiv.append(NewImage);
                            var NewInput = document.createElement("input");
                            NewInput.name = "slider_images[]";
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

              <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                <button type="submit" class="btn btn-primary mb-1 mb-sm-0 mr-0 mr-sm-1">{{__('data.Confirm')}}</button>
                <button type="reset" class="btn btn-outline-secondary">{{__('data.Reset')}}</button>
              </div>

            </form>
          </div>
        </div>
      </div>

    </div>
  </section>
@endsection


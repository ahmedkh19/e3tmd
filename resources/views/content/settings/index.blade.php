
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


              <label for="ad_price_field">{{ __('data.Ad price') }}</label>
              <div class="input-group mb-2">
                <input
                        id="ad_price_field"
                        type="text"
                        name="ad_price"
                        value="@if (old('ad_price')){{old('ad_price')}}@else{{$settings[1]->value}}@endif"
                        class="form-control"
                        placeholder="info@wasla.net"
                        aria-label="ad_price_field"
                />
              </div>

              <label for="min_amount_field">{{__('data.Minimum payment amount')}}</label>
              <div class="input-group mb-2">
                <input
                        type="text"
                        name="min_amount"
                        class="form-control"
                        placeholder="3"
                        value="@if (old('min_amount')){{old('min_amount')}}@else{{$settings[2]->value}}@endif"
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
                        value="@if (old('min_amount')){{old('min_amount')}}@else{{$settings[3]->value}}@endif"
                        aria-label="withdraw_min"
                        id="withdraw_min_field"
                />
              </div>
              <label>صور السلايدر</label>

              @error("slider_images.*")
              <p><span class="text-danger">برجاء التأكد من اختيار صورة</span></p>
              @enderror

              <div id="slider_images_div" class="input-group mb-2">

                @foreach (json_decode($settings[4]->value) as $image)

                  <div class="form-group" style="position:relative;margin:10px">
                    <span class="Programsclose">X</span>
                    <img src="{{ URL::to('front/assets/img/content/slider/' . $image) }}" width="100">
                    <input class="hidden" name="keep_images[]" value="{{ $image }}">
                  </div>

                @endforeach

                <div id="slider_images_before" class="form-group">
                  <label class="cursor-pointer border shadow-lg px-1 py-1">
                    <img src="{{ URL::to('/images/icons/add.png') }}" style="width:80px;">
                    <input id="slider_images" type="file" accept="image/*" class="hidden">
                  </label>
                </div>

              </div>

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

@section('page-script')
  <script>

    //muilt imgs
    let remove_img = document.querySelectorAll('.remove_img');
    let remove_img_arr = Array.from(remove_img)

    window.onload = function() {
      //Check File API support
      if (window.File && window.FileList && window.FileReader) {
        var filesInput = document.getElementById("files");
        filesInput.addEventListener("change", function(event) {
          var files = event.target.files; //FileList object
          var output = document.getElementById("result");
          for (var i = 0; i < 15; i++) {
            var file = files[i];
            //Only pics
            if (!file.type.match('image'))
              continue;
            var picReader = new FileReader();
            picReader.addEventListener("load", function(event) {
              var picFile = event.target;
              var div = document.createElement("div");
              div.innerHTML = "<span class='text-danger position-absolute remove_img' class='remove_img'>x</span><img class='thumbnail' src='" + picFile.result + "'" +
                      "title='" + picFile.name + "'/>";
              output.insertBefore(div, null);
              remove_img_arr.push(div.firstChild);
              console.log(div.firstChild);
              console.log(remove_img_arr);
              remove_img_arr.forEach(element => {
                element.addEventListener('click',()=>{
                  console.log(2)
                  element.parentElement.remove()
                })
              });
            });
            //Read the image
            picReader.readAsDataURL(file);
          }
        });
      } else {
        console.log("Your browser does not support File API");
      }
    }

  </script>

@endsection
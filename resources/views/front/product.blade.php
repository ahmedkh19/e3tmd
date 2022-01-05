@extends('front.layouts.master')
@section('title', $product->name )
@section('content')
    <!-- main content -->
    <main class="main-content">

      <!-- overlay -->
      <div class="overlay overflow-hidden pe-n"><img src="{{ URL('/front/assets/img/bg/bg_shape.png') }}" alt="background shape"></div>
      <!-- /.overlay -->

      <!-- content area -->
      <div class="content-section text-light pt-8" style="padding-bottom: 2rem;">
        <div class="container">
          <div class="row gutters-y">
            <div class="col-12">
              <header>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb-product breadcrumb-nowrap breadcrumb breadcrumb-angle bg-transparent pl-0 pr-0 mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('front.home_title') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route("shop") }}">{{ __('front.shop') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                  </ol>
                </nav>
                <h3 class="product_name mb-4">{{ $product->name }}</h3>
                <div class="d-flex flex-wrap align-items-center">
                  <ul class="tag-list d-none d-md-flex flex-wrap list-unstyled mb-0">
                    <li class="tag-item"><a href="" class="text-unset release-date"><i class="far fa-clock text-warning mr-1"></i> {{ DateTime::createFromFormat("!m",substr($product->created_at,5,2))->format('F') }} {{ substr($product->created_at,8,2) }} {{ substr($product->created_at,0,4) }}</a></li>
                  </ul>
                </div>
              </header>
              @if ( $product->pricing_method == 'Auction' )
              <div style="border:1px solid;margin-top: 10px;text-align:center;">
               <div style="padding: 10px 0">
                   <i class="fa fa-hourglass"></i>
                   <i class="col-3"><span class="day_time">00</span> {{ __('data.Days') }}</i>
                   <i class="col-3"><span class="hr_time">00</span> {{__('data.Hours')}}</i>
                   <i class="col-3"><span class="min_time">00</span> {{__('data.Minutes')}}</i>
                   <i class="col-3"><span class="sec_time">00</span> {{__('data.Seconds')}}</i>
                   <i class="fa fa-hourglass"></i>
               </div>
              </div>
              @endif
            </div>
            <div class="col-lg-8">
              <div class="row">
                <div class="col-12">
                  <div class="product-body">
                  @if ($product->main_image)
                    <!-- carousel wrapper-->
                    <div class="carousel-product">
                      <div class="slider text-secondary" data-slick="product-body">
                        <img src="{{ URL( '/uploads/images/products/'. $product->main_image) }}" alt="main_image">
                        @foreach($product_images as $image)
                        <img src="{{ URL( '/uploads/images/products/'. $image->name) }}" alt="account_image">
                        @endforeach
                      </div>
                      <div class="slider product-slider-nav text-secondary">
                        @if (count($product_images))
                            <img src="{{ URL( '/uploads/images/products/'. $product->main_image) }}" alt="main_image">
                        @endif
                        @foreach($product_images as $image)
                            <div class="slide-item px-1"><img src="{{ URL( '/uploads/images/products/'. $image->name) }}" class="screenshot" alt="account_image"></div>
                        @endforeach
                      </div>
                    </div>
                    <!-- /.carousel wrapper -->
                  @endif

                    <div class="alert alert-no-border alert-share d-flex mb-6" role="alert">
                      <span class="flex-1 fw-600 text-uppercase text-warning">{{__('data.Share')}}:</span>
                      <div class="social-buttons text-unset">
                        <a class="social-twitter mx-2" href="http://twitter.com/share?text={{ $product->name }}&url={{ url()->current() }}"><i class="fab fa-twitter"></i></a>
                        <a class="social-dribbble mx-2" href="https://api.whatsapp.com/send?text={{ $product->name }}%0A%0A{{ url()->current() }}"><i class="fab fa-whatsapp"></i></a>
                        <a class="social-instagram ml-2" href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&t={{ $product->name }}"><i class="fab fa-facebook"></i></a>
                      </div>
                    </div>
                    <div id="about" class="about mb-8">
                      <h6 class="mb-4 fw-400 text-uppercase">{{__('data.Account Details')}}</h6>
                      <hr class="border-secondary my-2">
                      <div>
                        <div class="collapse readmore" id="collapseSummary">
                          <p>{{ $product->description }}</p>
                        </div>
                        @if (strlen($product->description) > 470)
                        <a class="readmore-btn collapsed" data-toggle="collapse" href="#collapseSummary" aria-expanded="false" aria-controls="collapseSummary"></a>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="bg-dark_A-20 p-4 mb-4">
                <p>{{ $product->short_description }}</p>

                <div class="price-wrapper">
                  <div class="mb-3">
                    <div class="price">
                        <div class="price-current" @if ($highest_bid) style="text-decoration: line-through;" @endif>{{ $product->price ? $product->price . currency($product->currency,true): $product->start_bid_amount . currency($product->currency,true); }}</div>
                        
                        @if ($highest_bid)
                        <div class="price-current">{{ $highest_bid . currency($product->currency,true) }}</div>
                        @endif

                        @if (Session::has('bid_message'))
                            <div class="alert alert-error">{{ Session::get('bid_message') }}</div>
                        @endif
                    </div>
                      <?php
                      use App\Models\PasswordEncryption;
                      $EncryptionClass = new PasswordEncryption();
                      ?>
                    @if(!$product->isSold)
                        @if ($product->pricing_method == 'Fixed' )
                          @if( (Auth::check() && Auth::user()->id != $product->user_id) || !Auth::check() )
                            @if ( Auth::user()->roles_name[0] != "Member" )
                            <a class="discount">{{ __('data.Please open a member account to contact the sellers') }}</a>
                            @else
                            <a href="{{ route('chat.create', $EncryptionClass->encryptAES($product->id, env('AES_ENCRYPTION_KEY') )) }}" class="discount">تواصل مع البائع</a>
                            @endif
                          @endif
                        @else
                          @if($product->auction_end > date("Y-m-d H:i:s"))
                            @if(Auth::check())
                              @if( Auth::user()->id != $product->user_id )
                                <form style="display:flex" method="POST" action="{{ route('add_bid') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input class="col-4" step="any" name="amount" value="{{ $highest_bid ? $highest_bid +1 :$product->start_bid_amount + 1 }}" type="number">
                                    <button style="margin-left:10px;color:#fff;cursor:pointer" type="submit" class="col-6 discount">
                                        {{ __('data.Add a new price') }}</button>
                                </form>
                              @endif
                            @else
                            <div style="display:flex;">
                                <input class="col-4" step="any" value="{{ $highest_bid ? $highest_bid +1 :$product->start_bid_amount + 1 }}" type="number">
                                <a style="margin-left:10px" class="col-6 discount" data-toggle="modal" href="{{ route('login') }}" data-target="#userLogin">اضف سعر</a>
                            </div>
                            @endif
                          @else
                            <a class="discount">{{__('data.Auction ended')}}</a>
                          @endif
                        @endif
                    @else
                      <a class="discount">{{__('data.Sold')}}!</a>
                    @endif
                  </div>
                </div>

              </div>
              <div class="bg-dark_A-20 p-4">
                <h6 class="mb-3">{{__('data.Account Information')}}</h6>
                <hr class="border-secondary mt-2 mb-4">
                <ul class="list-unstyled mb-3">
                  <li>
                    <span class="platform">{{__('data.Platform')}}:</span>
                    @if ($product->os)
                      @if(Str::contains($product->os,'x'))
                        <span class="platform-item btn btn-sm btn-outline-warning"><i class="fab fa-xbox"></i> {{__('data.Xbox')}}</span>
                      @endif
                      @if(Str::contains($product->os,'p'))
                        <span class="platform-item btn btn-sm btn-outline-warning"><i class="fab fa-playstation"></i> {{__('data.Playstation')}}</span>
                      @endif
                      @if(Str::contains($product->os,'s'))
                        <span class="platform-item btn btn-sm btn-outline-warning"><i class="fa fa-mobile"></i> {{__('data.Smartphone')}}</span>
                      @endif
                    @else
                        <span class="platform-item btn btn-sm btn-outline-warning"><i class="fa fa-desktop"></i> {{__('data.Other')}}</span>
                    @endif
                  </li>
                </ul>
                <ul class="list-unstyled mb-3">
                  <li class="developer-wrapper">
                    <span class="platform">{{__('data.Seller')}} :</span>
                    <a href="{{ URL( '/user/' . $author->username) }}" class="developer-item btn btn-sm btn-secondary">{{ $author->name }}</a>
                  </li>
                </ul>
                <ul class="list-unstyled small-2 mb-3">
                  <li class="developer-wrapper">
                    <span class="platform">{{__('data.Categories')}} :</span>
                    <div>
                    @foreach ( $product->categories as $category )
                      <hr class="my-2 border-secondary">
                      <div class="d-flex align-items-center">
                        <span class="flex-1"><a href="{{ URL( '/categories/' . $category->slug) }}">{{ $category->name }}</a></span>
                      </div>
                    @endforeach
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content area -->

      <!-- featured -->
      @if (count($author_others))
      <section class="container text-light" style="margin-bottom: 2rem;">
        <div class="border border-secondary py-5 px-2">
          <div class="mx-3 mb-6">
            <h6 class="mb-4 fw-400 text-uppercase">{{__('data.More from this seller')}}</h6>
            <hr class="border-secondary my-2">
          </div>
          <div class="owl-carousel" data-carousel-items="1, 3, 6">
          @foreach ($author_others as $post)
            <!-- item -->
            <div class="item mx-3">
              <a href="{{ $post->slug }}"><img style="height:150px" src="/uploads/images/products/{{ $post->main_image }}" alt="Game" class="mb-3"></a>
              <a href="{{ $post->slug }}" class="text-uppercase fw-500 small-2 mb-0">{{ $post->name }}</a>
              <span class="d-block small text-warning">@if ($post->price) {{ $post->price . currency($post->currency,false) }} @else {{ $post->start_bid_amount . currency($post->currency,false) }} <i class="fas fa-clock"></i> @endif</span>
            </div>
            <!-- /.item -->
          @endforeach
          </div>
        </div>
      </section>
      @endif
      <!-- /.featured -->

      <!-- featured -->
      @if (count($similar_posts))
      <section class="container text-light">
        <div class="border border-secondary py-5 px-2">
          <div class="mx-3 mb-6">
            <h6 class="mb-4 fw-400 text-uppercase">{{__('data.Similar offers')}}</h6>
            <hr class="border-secondary my-2">
          </div>
          <div class="owl-carousel" data-carousel-items="1, 3, 6">
          @foreach ($similar_posts as $post)
            <!-- item -->
            <div class="item mx-3">
              <a href="{{ $post->slug }}"><img style="height:150px" src="/uploads/images/products/{{ $post->main_image }}" alt="Game" class="mb-3"></a>
              <a href="{{ URL( '/product/' . $post->slug) }}" class="text-uppercase fw-500 small-2 mb-0">{{ $post->name }}</a>
              <span class="time d-block small-4">{{ substr($post->created_at, 0, 10 ) }}</span>
              <span class="d-block small text-warning"><i class="far fa-eye"></i> {{ $post->viewed }}</span>
            </div>
            <!-- /.item -->
          @endforeach
          </div>
        </div>
      </section>
      @endif
      <!-- /.featured -->

    </main>
    <!-- /.main content -->
    <br>
    @if ( $product->pricing_method == 'Auction' )
    <script>
        let countDownDate = new Date("{{ date('M d, Y H:i:s', strtotime($product->auction_end)) }}").getTime();

        let x = setInterval( function() {

            let now = new Date().getTime();
            let distance = countDownDate - now;
                        
            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if ( distance < 0 ) {
                document.querySelector('.day_time').innerHTML = '00';
                document.querySelector('.hr_time').innerHTML = '00';
                document.querySelector('.min_time').innerHTML = '00';
                document.querySelector('.sec_time').innerHTML = '00';
                clearInterval(x);
            } else {
                document.querySelector('.day_time').innerHTML = ('0'+days).slice(-2);
                document.querySelector('.hr_time').innerHTML = ('0'+hours).slice(-2);
                document.querySelector('.min_time').innerHTML = ('0'+minutes).slice(-2);
                document.querySelector('.sec_time').innerHTML = ('0'+seconds).slice(-2);
            }

        }, 1000);
    </script>
    @endif
@stop

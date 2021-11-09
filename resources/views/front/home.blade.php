@extends('front.layouts.master')
@section('title', __('front.home_title'))

@section('content')
    <!-- header -->
    <header id="header" class="header h-fullscreen text-light">
      <div class="media-container parallax-window" data-parallax="scroll" data-image-src="{{ asset('front/assets/img/content/game-bg.jpg') }}"></div>
      <div class="overlay pe-n bg-dark_A-40"></div>
      <div class="overlay d-flex align-items-center">
        <div class="container text-center">
          <div class="row align-items-center">
            <div class="col-lg-10 mx-auto">
              <div>
                <img src="{{ asset('images/logo/logo.png') }}" alt="{{ __('front.e3tamd') }}">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="fadeIn ad-800ms">
        <div class="down-arrow floating-arrow absolute-center-X">
          <span class="fas fa-chevron-down"></span>
        </div>
      </div>
    </header>
    <!-- /.header -->

    <!-- Start Main Content -->
    <main class="main-content">

      <!-- content area -->
      <section id="about" class="content-section position-relative text-light text-center parallax-window" data-parallax="scroll" data-image-src="{{ asset('front/assets/img/content/bg-2.jpg') }}" data-overlay="8">
        <div class="container position-relative">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div>
                <h2>{{ __('front.about') }}</h2>
                <hr class="w-10 border-warning border-top-2 o-90">
                <p class="lead-2">يقدم موقع اعتمد خدمات بيع حسابات الألعاب بشتى أنواعها بالإضافة الى إمكانية بيع حسابات مواقع التواصل الاجتماعي او الأسماء المميزة مع توفير الأمان والخصوصية لكل من بيانات المشتري او البائع وتوفير خيارات كثيرة لعرض حسابك كالمزاد والبيع المباشر وغيرها مع توفير طرق متنوعة للدفع.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content area -->

      <!-- content area -->
      <section id="characters" class="characters content-section latest-articles text-light">
        <div class="container">
          <header class="section-header text-center">
            <h2>الأقسام المميزة</h2>
            <hr class="w-10 border-warning border-top-2 o-90">
          </header>
          <div class="row">
            <div class="col-sm-7 col-md-6 col-lg-3 mx-auto mb-7 md-lg-0">
              <article class="card article-post bg-transparent">
                <img style="height:160px;" class="rounded mb-4 svg-white" src="{{ asset('front/assets/img/poker-cards.svg') }}" alt="characters">
                <figure class="border border-secondary p-4">
                  <figcaption>
                    <h5 class="mt-1 text-unset"><a>أخرى</a></h5>
                    <hr class="my-4 border-secondary">
                    <q>هذا النص يمكن استبداله بنص اخر بديل</q>
                  </figcaption>
                </figure>     
              </article>
            </div>
            <div class="col-sm-7 col-md-6 col-lg-3 mx-auto mb-7 md-lg-0">
              <article class="card article-post bg-transparent">

                <img style="height:160px; color:white" class="rounded mb-4 svg-white" src="{{ asset('front/assets/img/user.svg') }}" alt="characters">
                <figure class="border border-secondary p-4">
                  <figcaption>
                    <h5 class="mt-1 text-unset"><a>حسابات مواقع التواصل</a></h5>
                    <hr class="my-4 border-secondary">
                    <q>هذا النص يمكن استبداله بنص اخر بديل</q>
                  </figcaption>
                </figure>
              </article>
            </div>
            <div class="col-sm-7 col-md-6 col-lg-3 mx-auto mb-7 mb-md-0">
              <article class="card article-post bg-transparent">
                <img style="height:160px;" class="rounded mb-4 svg-white" src="{{ asset('front/assets/img/playstation.svg') }}" alt="characters">
                <figure class="border border-secondary p-4">
                  <figcaption>
                    <h5 class="mt-1 text-unset"><a>حسابات العاب الكونسل وال PC</a></h5>
                    <hr class="my-4 border-secondary">
                    <q>هذا النص يمكن استبداله بنص اخر بديل</q>
                  </figcaption>
                </figure>     
              </article>
            </div>
            <div class="col-sm-7 col-md-6 col-lg-3 mx-auto mb-7 mb-md-0">
              <article class="card article-post bg-transparent">
                <img style="height:160px;" class="rounded mb-4 svg-white" src="{{ asset('front/assets/img/games.svg') }}" alt="characters">
                <figure class="border border-secondary p-4">
                  <figcaption>
                    <h5 class="mt-1 text-unset"><a>حسابات العاب الجوال</a></h5>
                    <hr class="my-4 border-secondary">
                    <q>هذا النص يمكن استبداله بنص اخر بديل</q>
                  </figcaption>
                </figure>     
              </article>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content area -->

      @if (count($accounts))
      <!-- carousel area -->
      <section id="gallery" class="section ig-slider-def gradient-lg">
        <div id="gameCarousel" style="max-width: 700px; margin: auto;box-shadow:0 0 0 10px hsl(0, 0%, 80%), 0 0 0 15px hsl(0, 0%, 90%);" class="carousel slide carousel-fade" data-ride="carousel">
          <!-- Indicators -->
          <div class="po_carousel__wrapper">
            <ol class="list-unstyled carousel-indicators def po_carousel-indicators">
              @for($i=0; $i < count($accounts); $i++)
              <li data-target="#gameCarousel" data-slide-to="{{ $i }}" class="@if( $i == 0 ) active @endif"></li>
              @endfor
            </ol>
          </div>
          <!-- carousel items -->
          <div class="carousel-inner">
          @foreach($accounts as $key => $account)
            <div class="carousel-item @if($key==0) active @endif">
              <div class="ig-img br-n bp-c bs-c" style="background-image: url({{ URL('/uploads/images/products/'.$account->main_image) }});"></div>
              <div class="ig-sl-gr text-light text-uppercase my-5 my-lg-0">
                <div class="text-center p-7">
                  <h3 class="mb-0 mb-md-2"><a href="{{ URL('/product/' . $account->slug ) }}">{{ $account->name }}</a></h3>
                </div>
              </div>
            </div>
          @endforeach
          </div>
          <!-- /.carousel items -->
          <!-- carousel nav -->
          <a class="carousel-control-prev" href="#gameCarousel" data-slide="prev"><span class="icon-cl-prev pe-7s-angle-left"></span></a>
          <a class="carousel-control-next" href="#gameCarousel" data-slide="next"><span class="icon-cl-next pe-7s-angle-right"></span></a>
          <!-- /.carousel nav -->
        </div>
      </section>
      <!-- /.carousel area -->
      @endif

      <!-- content area -->
      <section id="contact" class="content-section latest-articles text-light">
        <div class="container">
          <header class="section-header text-center">
            <h2>Contact Us</h2>
            <hr class="w-10 border-warning border-top-2 o-90">
            <p class="lead-2">للشكاوى والاقتراحات يرجى التواصل معنا </p>
          </header>
          <div class="row gutters-y align-items-center">
            <div class="col-lg-10 mx-auto">
                <form data-form="contact_form" id="contact_form" action="{{ route('contact_us') }}" class="input-transparent" method="POST">
                  <span class="alert" style="display:none" role="alert"></span>
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <input class="form-control form-control-lg" type="text" name="name" placeholder="Your Name" required="">
                    </div>
                    <div class="form-group col-md-12">
                      <input class="form-control form-control-lg" type="email" name="email" placeholder="Your Email Address" required="">
                    </div>
                  </div>
                  <div class="form-group">
                    <input name="subject" type="text" class="form-control" placeholder="Subject" maxlength="100" required="">
                  </div>
                  <div class="form-group">
                    <textarea class="form-control form-control-lg" rows="4" placeholder="Your Message" name="message" required=""></textarea>
                  </div>
                  <button class="btn btn-lg btn-warning" type="submit">Send it over</button>
              </form>
            </div>

          </div>
        </div>
      </section>
      <!-- /.content area -->

    </main>
@stop

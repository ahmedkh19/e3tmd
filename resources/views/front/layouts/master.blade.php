<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Config::get('app.name') }} - @yield('title')</title>

    <!-- CSS -->
    <link href="{{ asset('front/assets/css/fonts/etline-font.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/fonts/fontawesome/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/fonts/pe-icon-7-stroke.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/fonts/themify-icons.css') }}" rel="stylesheet">

    <link href="{{ asset('front/assets/plugins/owl.carousel/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/plugins/slick/slick.css') }}" rel="stylesheet">

    <link href="{{ asset('front/assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/styles.css') }}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logo/favicon.ico') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    @if (Config::get('app.locale') == 'ar')
    <style>
      @font-face {
        font-family: theSans;
        src: url('{{ asset("front/assets/fonts/THESANSARABIC-BOLD.ttf") }}');
      }
        body, h1, h2, h3, h4, h5, h6, p, a {
            font-family: 'theSans', sans-serif !important;
        }

      .svg-white {
        filter: brightness(0) invert(1);

      }
    </style>
    @endif

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script src="{{ asset('/front/assets/js/bootstrap.bundle.min.js') }}"></script>
    
    <script>
        window.onload = function() {
            if (sessionStorage.getItem("seach_type1")) {
                document.getElementById("dropdownMenuButton1").innerHTML = sessionStorage.getItem("seach_type1");
                document.getElementById("seach_type1").value = sessionStorage.getItem("seach_type1");
            }
        }
        function search_accounts() {
            document.getElementById("dropdownMenuButton1").innerHTML = "accounts";
            document.getElementById("seach_type1").value = "accounts";
            sessionStorage.setItem("seach_type1", "accounts");
        }
        function search_users() {
            document.getElementById("dropdownMenuButton1").innerHTML = "users";
            document.getElementById("seach_type1").value = "users";
            sessionStorage.setItem("seach_type1", "users");
        }
    </script>
  </head>
  <body class="page-body">

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-nav zi-3">
      <div class="container">
        <div class="row">
          <div class="col-4 col-sm-3 col-md-2 mr-auto">
            <a class="navbar-brand logo" href="{{ route('home') }}">
              <img src="{{ asset('images/logo/logo.png') }}" alt="{{ __('front.e3tamd') }}" class="logo-light mx-auto">
            </a>
          </div>
          <div class="col-4 d-none d-lg-block mx-auto">
            <form class="input-group border-0 bg-transparent" action="{{ route('search') }}">
              <div class="dropdown w-25">
                <button style="position:absolute; right:0px;height: 100%;" class="btn btn-warning dropdown-toggle px-1 fw-light text-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">Accounts</button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a onclick="search_accounts()" style="cursor:pointer;" class="dropdown-item">Accounts</a></li>
                    <li><a onclick="search_users()" style="cursor:pointer;" class="dropdown-item">Users</a></li>
                </ul>
              </div>
              <input class="form-control" name="search" value="@yield('search')" type="search" placeholder="{{ __('front.search') }}" aria-label="Search">
              <div class="input-group-append">
                <input type="hidden" name="type" value="accounts" id="seach_type1" />
                <button class="btn btn-sm btn-warning text-secondary my-0 mx-0" type="submit"><i class="fas fa-search"></i></button>
              </div>
            </form>
          </div>
          <div class="col-8 col-sm-8 col-md-8 col-lg-6 col-xl-4 ml-auto text-right">
          @if (Auth::check())
            <a class="btn btn-sm btn-warning text-secondary mr-2" href="{{ route('dashboard-ecommerce') }}">{{ __('front.profile') }}</a>
            <a class="btn btn-sm text-light d-none d-sm-inline-block" href="{{ route('logout') }}">{{ __('front.logout') }}</a>
          @else
            <a class="btn btn-sm btn-warning text-secondary mr-2" href="{{ route('login') }}" data-toggle="modal" data-target="#userLogin">{{ __('front.sign_in') }}</a>
            <a class="btn btn-sm text-light d-none d-sm-inline-block" href="{{ route('register') }}">{{ __('front.sign_up') }}</a>
          @endif
            <ul class="nav navbar-nav d-none d-sm-inline-flex flex-row">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle small" href="#" id="dropdownGaming" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mr-2 fas fa-globe"></i>{{ Str::replace('ar', 'ع', Config('app.locale')) }} </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="dropdownGaming">
                  <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}">عربي</a>
                  <a class="dropdown-item" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">English</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <button class="navbar-toggler navbar-toggler-fixed" type="button" data-toggle="collapse" data-target="#collapsingNavbar" aria-controls="collapsingNavbar" aria-expanded="false" aria-label="Toggle navigation">☰</button>
        <div class="collapse navbar-collapse" id="collapsingNavbar">
          <ul class="navbar-nav">
            <li class="nav-item dropdown dropdown-hover">
              <a class="nav-link dropdown-toggle pl-lg-0" href="#" id="dropdownGaming_games" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ __('front.accounts') }} </a>
              <div style="max-height: 300px;overflow: auto;" class="dropdown-menu dropdown-menu-dark-lg" aria-labelledby="dropdownGaming_games">
              <?php $categories = \App\Models\Category::where('is_active','=',true)->get(); ?>
              @if ($categories) @foreach ($categories as $category)
                @if(!$category->parent_id)
                <a class="dropdown-item" href="{{ route('category', $category->slug) }}">{{ $category->name }}</a>
                @endif
              @endforeach @else <a class="dropdown-item">No Categories</a> @endif
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('shop') }}">{{ __('front.shop') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('home') }}/shop#bids">{{ __('front.bids') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('home') }}/#about">{{ __('front.about') }}</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- /.navbar --> 

    @yield('content')
    
    <!-- footer -->
    <footer class="footer footer-dark bg-dark py-9">
      <div class="container">
          <div class="row gutters-y">
              <div class="col-6 col-lg-3">
                <a href="#" class="logo d-block mb-4"><img src="{{ asset('images/logo/logo.png') }}" alt="{{ __('front.e3tamd') }}" class="logo-dark"></a>
                <p>{{__('data.P2')}}</p>
                <div class="social-buttons">
                  <a class="social-twitter" href="#"><i class="fab fa-twitter"></i></a>
                  <a class="social-dribbble" href="#"><i class="fab fa-dribbble"></i></a>
                  <a class="social-instagram" href="#"><i class="fab fa-instagram"></i></a>
                </div>
              </div>

              <div class="col-6 col-lg-2">
              </div>

              <div class="col-6 col-lg-2">
                <h6 class="text-uppercase fw-600 mb-4">{{__('data.About')}}</h6>
                <div class="nav flex-column">
                  <a class="nav-link" href="{{ route('home') }}/#about">{{ __('data.Who we are') }}</a>
                  <a class="nav-link" href="{{ asset('uploads/pdf/Terms&Privacy.pdf') }}">{{__('data.Privacy Policy')}}</a>
                  
                </div>
              </div>

              <div class="col-6 col-lg-2">
                <h6 class="text-uppercase fw-600 mb-4">Help</h6>
                <div class="nav flex-column">
                  <a class="nav-link" href="{{ route('home') }}/#contact">{{ __('data.Contact Us') }}</a>
                  <a class="nav-link" href="https://api.whatsapp.com/send?phone=966557990467&text={{__('data.I have a question')}}">{{__('data.Support')}}</a>
                  <a class="nav-link" href="{{ asset('uploads/pdf/Terms&Privacy.pdf') }}">{{__('data.Terms & conditions')}}</a>
                </div>
              </div>
              
              <div class="col col-lg-3 order-lg-last">
                <div class="mb-6">
                  <h6 class="text-uppercase fw-600 mb-4">{{__('data.Ways to pay')}}</h6>
                  <div class="text-light lead-5 lh-1">
                    <a href="#" class="mr-2"><i class="fab fa-cc-paypal"></i></a>
                    <a href="#" class="mr-2"><i class="fab fa-cc-visa"></i></a>
                    <a href="#" class="mr-2"><i class="fab fa-cc-mastercard"></i></a>
                  </div>
                </div>
                <div>
                  <h6 class="mb-2">{{__('data.Reviews')}}</h6>
                  <div class="text-warning lead-1">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star text-secondary"></i>
                  </div>
                </div>
              </div>
          </div>
      </div>
    </footer>
    <!-- /.footer -->

    <!-- sign In -->
    <div class="modal fade" id="userLogin" tabindex="-1" role="dialog" aria-labelledby="userLoginTitle" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content bg-dark text-light">
          <div class="modal-header border-secondary">
            <h5 class="modal-title" id="userLoginTitle">Log in</h5>
            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div>
              <div class="text-center my-6"> 
                <a class="btn btn-circle btn-sm btn-google mr-2" href="{{ route('socialite.login', 'google') }}"><i class="fab fa-google"></i></a>
                <a class="btn btn-circle btn-sm btn-facebook mr-2" href="{{ route('socialite.login', 'facebook') }}"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-circle btn-sm btn-twitter" href="{{ route('socialite.login', 'twitter') }}"><i class="fab fa-twitter"></i></a>
              </div>
              <span class="hr-text small my-6">Or</span>
            </div>
            <form class="input-transparent" action="{{ route('login.do') }}" method="POST">
              @csrf
              <div class="form-group">
                <input type="text" class="form-control border-secondary" name="email" placeholder="email">
              </div>
              <div class="form-group">
                <input type="password" class="form-control border-secondary" name="password" placeholder="Password">
              </div>
              <div class="form-group d-flex justify-content-between">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" name="remember_me" checked="" id="rememberMeCheck">
                  <label class="custom-control-label" for="rememberMeCheck">Remember me</label> 
                </div>
                <a class="small-3" href="{{ route('reset-password') }}">Forgot password?</a>
              </div>
              <div class="form-group mt-6">
                <button class="btn btn-block btn-warning" type="submit">Login</button>
              </div>
            </form>
            <span class="small">Don't have an account? <a href="{{ route('register') }}">Create an account</a></span>
          </div>
        </div>
      </div>
    </div>
    <!-- /.sign In -->

    <!-- jQuery -->
    <script src="{{ asset('front/assets/js/jquery.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('front/assets/js/bootstrap.min.js') }}"></script>
    
    <!-- Parallax -->
    <script src="{{ asset('front/assets/plugins/parallax/parallax.js') }}"></script>

    <!-- User JS -->
    <script src="{{ asset('front/assets/js/scripts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('front/assets/js/main.js') }}" id="_mainJS" data-plugins="load"></script>

  </body>
</html>

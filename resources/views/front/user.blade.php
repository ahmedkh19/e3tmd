@extends('front.layouts.master')
@section('title', $user->name )
@section('content')
    <!-- header -->
    <header class="pt-10 p-relative">
      <div class="overlay br-n bs-c bp-r pe-n" data-parallax="scroll" data-z-index="1" data-image-src="{{ $user->background_url }}"></div>
      <div class="position-relative zi-1 d-flex align-items-end flex-wrap h-100">
        <div class="release-subheader">
          <div class="release-container">
            <div class="pb-9 w-100 text-light text-center">
              <div class="img-xl position-relative br-n bp-c bs-c article-image ar-1_1 mx-auto rounded-circle border border-secondary mb-6" style="background-image: url({{ $user->avatar }})">
                <span class="position-absolute b-0 r-0 text-secondary lead-3 d-block bg-warning p-2 rounded-circle lh-1"><input type="file" class="custom-file-input position-absolute l-0 t-0 b-0 h-auto" id="customFile"><i class="far fa-image"></i></span>
              </div>
              <h3>{{ $user->name }}</h3>
              <?php $online = Cache::has('user-is-online-' . $user->id) ? true: false;?>
              <span class="d-flex align-items-center justify-content-center fw-500 text-shadow"><i class="fas fa-circle @if($online) text-light @else text-warning @endif small-6 mr-1"></i>@if($online) Online @else Offline @endif</span>
            </div>
          </div>
        </div>
        <div class="profile-nav w-100 border-top border-bottom border-secondary">
          <div class="container">
            <nav class="navbar navbar-expand-lg mnh-auto px-0 lh-1">
              <button class="navbar-toggler ml-auto py-5 pl-5 pr-0 pr-sm-5" type="button" data-toggle="collapse" data-target="#navbarProfile" aria-controls="navbarProfile" aria-expanded="false" aria-label="Toggle navigation">
                <span class="fas fa-bars lead-3 text-warning"></span>
              </button>
            
              <div class="collapse navbar-collapse" id="navbarProfile">
                <ul class="profile-tabs nav nav-tabs list-unstyled mb-0 d-flex justify-content-around w-100 flex-row" id="profile-tabs" role="tablist">
                  <li class="py-2 py-lg-0">
                    <a id="mp-2-01-tab" data-toggle="tab" href="#mp-2-01-c" role="tab" aria-controls="mp-2-01-c" aria-selected="true" class="profile-nav-link text-uppercase text-center active show">
                      <span class="pr-icon-nav ti-layout-cta-left lead-4 d-block mb-3"></span>
                      <span class="small-2 fw-400">About</span>
                    </a>
                  </li>
                  <li class="py-2 py-lg-0">
                    <a id="mp-2-02-tab" data-toggle="tab" href="#mp-2-02-c" role="tab" aria-controls="mp-2-02-c" aria-selected="false" class="profile-nav-link text-uppercase text-center">
                      <span class="pr-icon-nav ti-game lead-4 d-block mb-3"></span>
                      <span class="small-2 fw-400">Accounts</span>
                    </a>
                  </li>
                </ul>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </header>
    <!-- /.header -->

    <!-- main content -->
    <main class="main-content position-relative">

      <!-- overlay -->
      <div class="bg-theme overlay pe-n zi-1">
        <div class="overlay pe-n br-n bp-c bs-c o-30" style="background-image: url({{ asset('/front/assets/img/bg/bg_shape.png') }});"></div>
      </div>
      <!-- /.overlay -->

      <!-- content area -->
      <div class="content-section position-relative text-light zi-2">
        <div class="container">
          <!-- tab panes -->
          <div id="profile-tabs-content" class="tab-content position-relative w-100">
            <!-- tab item -->
            <div class="tab-pane fade active show" id="mp-2-01-c" role="tabpanel" aria-labelledby="mp-2-01-tab">
              <div class="position-relative">
                <div class="row">
                  <div class="col-lg-7 mb-9 mb-lg-0">
    
                    <div id="about" class="mb-8">
                      <h4>About</h4>
                      <hr class="w-10 border-top-2 mt-5 mb-5 ml-0 mr-auto border-warning">
                      <div class="row">
                        <div class="col-10 col-lg-11">
                        @if ($user->information->gender == "male")
                          <span class="lead-1"><i class="fa fa-male"></i> Male</span>
                        @elseif ($user->information->gender == "Female")
                          <span class="lead-1"><i class="fa fa-female"></i> Female</span>
                        @endif
                        </div>
                        <div class="col-10 col-lg-11">
                          <span class="lead-1"><i class="fa fa-calendar"></i> Joined in: {{ date('d M Y', strtotime($user->created_at)); }}</span>
                        </div>
                      </div>
                    </div>

                    <!-- comments -->
                    <div id="comments" class="mb-0">
                      <div class="row">
                        <div class="col-12">
                          <h4 class="mb-4">Comments ({{ count($comments) }})</h4>
                          <hr class="w-10 border-top-2 mt-5 mb-7 ml-0 mr-auto border-warning">
                        </div>
                      </div>
                      <div class="row">
                        @if(session('error_comment'))
                        <span class="alert alert-danger">{{ session('error_comment') }}</span>
                        @endif
                        @if(session('success_comment'))
                        <span class="alert alert-success">{{ session('success_comment') }}</span>
                        @endif
                        @if ($cancomment)
                        <div class="col-12 mb-8">
                          <form action="{{ route('user.store', $user->id) }}" method="POST" class="input-transparent pb-8 border-bottom border-secondary">
                            @csrf
                            <div class="form-row">
                              <div class="form-group col-3 col-sm-2">
                                <img class="rounded" src="@if(Auth::user()->avatar) {{ URL( '/uploads/images/avatars/' . Auth::user()->avatar) }} @else  {{ URL( '/uploads/images/avatars/user.jpg') }} @endif" alt="{{ Auth::user()->name }}">
                              </div>
                              <div class="form-group col-9 col-sm-10">
                                <textarea class="form-control form-control" rows="4" placeholder="Your Message" name="message" required="">{{ @old("message") }}</textarea>
                              </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-end">
                              <div><button class="btn btn-warning" type="submit">Send</button></div>
                            </div>
                          </form>
                        </div>
                        @endif
                        <div class="col-12">
                          <div class="row">

                          @if (count($comments)) @foreach ($comments as $comment)
                            <!-- comment-item -->
                            <div class="col-12 comment-item mb-7">
                              <div class="form-row">
                                <div class="col-3 col-sm-2">
                                  <div class="comment-img">
                                    <img src="@if(\App\Models\User::find($comment->commenter_id)->avatar) {{ URL('/uploads/images/avatars/' . \App\Models\User::find($comment->commenter_id)->avatar) }} @else {{ URL('/uploads/images/avatars/user.jpg') }} @endif" class="rounded" alt="{{ \App\Models\User::find($comment->commenter_id)->name }}">
                                  </div>
                                </div>
                                <div class="col-9 col-sm-10">
                                  <div class="comment-main border border-secondary"> 
                                    <div class="d-md-flex comment-header border-bottom border-secondary px-4 py-3">
                                      <div class="d-flex align-items-center flex-1">
                                        <h6 class="comment-username fw-500 mb-0"><a href="{{ URL( '/user/' . \App\Models\User::find($comment->commenter_id)->username); }}">{{ \App\Models\User::find($comment->commenter_id)->name }}</a></h6>
                                      </div>
                                      <div>
                                        <a class="comment-metadata text-warning small">{{ date('d M Y H:i', strtotime($comment->created_at)); }}</a>
                                      </div>
                                    </div>
                                    <div class="p-4">
                                      <p class="small-2 mb-0">{{ $comment->comment }}</p>
                                    </div>
                                  </div>
                                </div>  
                              </div>
                            </div>
                            <!-- /.comment-item -->
                            @endforeach @else
                            <div class="col-12 comment-item mb-7">
                              <div class="form-row">
                                <div class="col-9 col-sm-10">
                                  <div class="comment-main border border-secondary"> 
                                    <div class="d-md-flex comment-header border-bottom border-secondary px-4 py-3">
                                        <h6 class="comment-username fw-500 mb-0">No Comments</h6>
                                    </div>
                                  </div>
                                </div>  
                              </div>
                            </div>
                            @endif

                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /.comments -->
                  </div>
                  <div class="col-lg-5">
                    <div class="card bg-dark_A-20 border border-secondary mb-6">
                      <div class="px-4 pt-3"><span class="fw-600 text-uppercase small-1"><span><i class="fas fa-share-alt text-warning mr-2"></i></span>Socials</span></div>
                      <div class="px-5 py-6">

                        <div class="mb-6">
                          <div class="row no-gutters">
                            <div class="col-3 item_img d-none d-sm-flex align-items-center">
                              <i class="fa fa-mobile"></i>
                            </div>
                            <div class="col-9 item_content flex-1 flex-grow pl-0 pl-sm-3 pr-3">
                              <p class="item_title text-lt small-1 mb-0">@if($user->mobile) {{ $user->mobile }} @else Nothing here. @endif</p>
                            </div>
                          </div>
                        </div>

                        <div class="mb-6">
                          <div class="row no-gutters">
                            <div class="col-3 item_img d-none d-sm-flex align-items-center">
                              <i class="fab fa-twitter"></i>
                            </div>
                            <div class="col-9 item_content flex-1 flex-grow pl-0 pl-sm-3 pr-3">
                              <p class="item_title text-lt small-1 mb-0">@if($user->information->twitter) {{ $user->information->twitter }} @else Nothing here. @endif</p>
                            </div>
                          </div>
                        </div>

                        <div class="mb-6">
                          <div class="row no-gutters">
                            <div class="col-3 item_img d-none d-sm-flex align-items-center">
                              <i class="fab fa-facebook"></i>
                            </div>
                            <div class="col-9 item_content flex-1 flex-grow pl-0 pl-sm-3 pr-3">
                              <p class="item_title text-lt small-1 mb-0">@if($user->information->facebook) {{ $user->information->facebook }} @else Nothing here. @endif</p>
                            </div>
                          </div>
                        </div>

                        <div class="mb-6">
                          <div class="row no-gutters">
                            <div class="col-3 item_img d-none d-sm-flex align-items-center">
                              <i class="fab fa-instagram"></i>
                            </div>
                            <div class="col-9 item_content flex-1 flex-grow pl-0 pl-sm-3 pr-3">
                              <p class="item_title text-lt small-1 mb-0">@if($user->information->instagram) {{ $user->information->instagram }} @else Nothing here. @endif</p>
                            </div>
                          </div>
                        </div>           

                        <div class="mb-6">
                          <div class="row no-gutters">
                            <div class="col-3 item_img d-none d-sm-flex align-items-center">
                              <i class="fab fa-twitch"></i>
                            </div>
                            <div class="col-9 item_content flex-1 flex-grow pl-0 pl-sm-3 pr-3">
                              <p class="item_title text-lt small-1 mb-0">@if($user->information->twitch) {{ $user->information->twitch }} @else Nothing here. @endif</p>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            <!-- /.tab item -->

            <!-- tab item -->
            <div class="tab-pane fade" id="mp-2-02-c" role="tabpanel" aria-labelledby="mp-2-02-tab">
                <header class="header mb-4">
                  <div class="row">
                    <div class="col-10 col-lg-11">
                      <h3>Accounts ({{ $accounts_count }})</h3>
                      <hr class="w-5 border-top-2 mt-5 mb-5 ml-0 mr-auto border-warning">
                    </div>
                  </div>
                </header>
                <div class="row">

                @if($accounts_count) @foreach($accounts as $account)
                  <!-- item -->
                  <div class="col-md-12 mb-4">
                    <a href="{{ URL('/product/' . $account->slug) }}" class="product-item">
                      <div class="border border-secondary">
                        <div class="row align-items-center no-gutters">
                          <div class="item_img d-none d-md-block">
                            <img class="profile-glib img bl-3 text-primary" src="{{ URL('/uploads/images/products/' . $account->main_image) }}" alt="Games Store">
                          </div>
                          <div class="item_content flex-1 flex-grow pl-4 pl-sm-6 pr-6 py-4">
                            <h6 class="item_title small-1 fw-600 text-uppercase mb-2">{{ $account->name }}</h6>
                            <div class="position-relative">
                              <span class="item_genre text-warning small fw-600"><i class="fa fa-eye"></i> {{ $account->viewed }}</span>
                            </div>
                            <div class="mb-0">
                            @if ($account->os)
                                @if(Str::contains($account->os,'x'))
                                    <i class="fab fa-xbox"></i>
                                @endif
                                @if(Str::contains($account->os,'p'))
                                    <i class="fab fa-playstation"></i>
                                @endif
                                @if(Str::contains($account->os,'s'))
                                    <i class="fa fa-mobile"></i>
                                @endif
                            @endif
                            </div>
                            <div class="position-relative">
                              <span class="item_genre text-warning small fw-600">
                              <?php 
                                  $hold = '';
                                  foreach ($account->categories as $category) {
                                      $hold .= ', ' . $category->name;
                                  }
                                  if ($hold) {
                                      echo substr($hold,2);
                                  }
                              ?>
                              </span>
                            </div>
                          </div>
                          <div>
                            <div class="row align-items-center h-100 no-gutters">
                              <div class="text-right text-light small-2 pr-4 pr-sm-6">
                                <span class="fw-500"><span class="text-warning fw-600">{{ $account->price ? $account->price . currency($account->currency,false): $account->start_bid_amount . currency($account->currency,false); }}<br>
                                @if ($account->auction_end)
                                <span class="fw-500"><i class="fas fa-clock"></i> {{ $account->auction_end }}</span>
                                @endif
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                  <!-- /.item -->
                  @endforeach @else
                   <p style="display:block; margin: auto;">لا يوجد حسابات</p>
                  @endif

                </div>
                <div class="col-12">
                  @if ($accounts_count)
                    <!-- pagination -->
                    <nav class="mt-4 pt-4 border-top border-secondary" id="ma-2-01-c" aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                        <li onclick="pagination('prev')" class="page-item">
                            <a class="page-link" aria-label="Previous">
                            <span class="ti-angle-left small-7" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        @for ($i = 1; $i <= ceil($accounts_count/10); $i++)
                        <li onclick="pagination({{ $i }})" class="page-item @if ($i==1) active @endif @if ($i>3) d-none @endif"><a class="page-link">{{ $i }}</a></li>
                        @endfor
                        <li onclick="pagination('next')" class="page-item">
                            <a class="page-link" aria-label="Next">
                            <span class="ti-angle-right small-7" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                            </a>
                        </li>
                        </ul>
                    </nav>
                    <!-- /.pagination -->
                  @endif
                </div>
              </div>
            </div>
            <!-- /.tab item -->

          </div>
        </div>  
      </div>
      <!-- /.content area -->

    </main>
    <!-- /.main content -->
    <script src="/front/assets/js/product_slider.js"></script>
@stop

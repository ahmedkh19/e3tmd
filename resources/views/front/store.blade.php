@extends('front.layouts.master')
@section('title', __('front.shop'))

@section('content')
    @include('front.includes.StoreHeader',[ "best_deals" => $best_deals ])
    <!-- main content -->
    <main class="main-content">

      <!-- content area -->
      <section class="content-section top_sellers carousel-spotlight ig-carousel pt-0 text-light">
        <div class="container">
          <header class="header">
            <h2 id="bids">{{__('data.Most popular products')}}</h2>
          </header>
          <div class="position-relative">
            <div class="row">
              <div class="col-lg-8">
                <!-- nav tabs -->
                <ul class="spotlight-tabs spotlight-tabs-dark nav nav-tabs border-0 mb-5 position-relative flex-nowrap" id="most_popular_products-carousel-01" role="tablist">
                  <li class="nav-item text-fnwp position-relative">
                    <a class="nav-link active show" id="mp-2-01-tab" data-toggle="tab" href="#mp-2-01-c" role="tab" aria-controls="mp-2-01-c ma-2-01-c" aria-selected="true">{{__('data.Accounts')}}</a>
                  </li>
                  <li class="nav-item text-fnwp position-relative"> 
                    <a class="nav-link" id="mp-2-02-tab" data-toggle="tab" href="#mp-2-02-c" role="tab" aria-controls="mp-2-02-c ma-2-02-c" aria-selected="false">{{__('data.Bids')}}</a>
                  </li>
                </ul>
                <!-- /.nav tabs -->
                <!-- tab panes -->
                <div id="color_sel_Carousel-content_02" class="tab-content position-relative w-100">
                  <!-- tab item -->
                  <div class="tab-pane fade active show" id="mp-2-01-c" role="tabpanel" aria-labelledby="mp-2-01-tab">
                    <div class="row">

                    @if ( isset($new_products['products']) && $new_products['products']->toArray() )
                      @foreach ($new_products['products'] as $product)
                      <!-- item -->
                      <div class="col-md-12 mb-5">
                        <a href="{{ URL( '/product/' . $product->slug ) }}" alt="{{ $product->name }}" class="product-item">
                          <div class="row flex-column text-sm-left text-center flex-sm-row align-items-center justify-content-sm-left justify-content-center no-gutters">
                            <div class="item_img d-block">
                              <img class="img bl-3 text-primary" width="125px" src="{{ URL( '/uploads/images/products/' . $product->main_image ) }}" alt="{{ $product->name }}">
                            </div>
                            <div class="item_content flex-1 flex-grow pl-0 pl-sm-6 pr-6">
                              <h6 class="item_title small-1 fw-600 text-uppercase mb-1">{{ $product->name }}</h6>
                              <div class="mb-0">
                                @if ($product->os)
                                    @if(Str::contains($product->os,'x'))
                                        <i class="fab fa-xbox"></i>
                                    @endif
                                    @if(Str::contains($product->os,'p'))
                                        <i class="fab fa-playstation"></i>
                                    @endif
                                    @if(Str::contains($product->os,'s'))
                                        <i class="fa fa-mobile"></i>
                                    @endif
                                @endif
                              </div>
                              <div class="position-relative">
                                <?php $cats = []; foreach ($product->categories as $cat) { array_push($cats, $cat->name); } ?>
                                <span class="item_genre small fw-600">{{ implode(', ',$cats) }}</span>
                              </div>
                            </div>
                            <div class="item_discount d-block">
                              <div class="row align-items-center h-100 no-gutters">
                                <div class="text-right text-secondary px-6">
                                  <span class="fw-600 btn bg-warning">{{ $product->price . currency($product->currency,false) }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="item_price">
                              <div class="row align-items-center h-100 no-gutters">
                                <div class="text-right">
                                  <span class="fw-600"><i class="fa fa-eye"></i> {{ $product->viewed }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </a>
                      </div>
                      <!-- /.item -->
                      @endforeach
                    @else
                      <p style="margin: auto;">{{__('data.No accounts')}}</p>
                    @endif

                    </div>
                  </div>
                  <!-- /.tab item -->

                  <!-- tab item -->
                  <div class="tab-pane fade" id="mp-2-02-c" role="tabpanel" aria-labelledby="mp-2-02-tab">
                    <div class="row">

                    @if ( isset($bids_products['products']) && $bids_products['products']->toArray() ) 
                      @foreach ($bids_products['products'] as $product)
                      <!-- item -->
                      <div class="col-md-12 mb-5">
                        <a href="{{ URL( '/product/' . $product->slug ) }}" alt="{{ $product->name }}" class="product-item">
                          <div class="row flex-column flex-sm-row text-center text-sm-left  align-items-center no-gutters">
                            <div class="item_img d-block">
                              <img class="img bl-3 text-primary" width="125px" src="{{ URL( '/uploads/images/products/' . $product->main_image ) }}" alt="{{ $product->name }}">
                            </div>
                            <div class="item_content flex-1 flex-grow pl-0 pl-sm-6 pr-6">
                              <h6 class="item_title small-1 fw-600 text-uppercase mb-1">{{ $product->name }}</h6>
                              <div class="mb-0">
                                @if ($product->os)
                                    @if(Str::contains($product->os,'x'))
                                        <i class="fab fa-xbox"></i>
                                    @endif
                                    @if(Str::contains($product->os,'p'))
                                        <i class="fab fa-playstation"></i>
                                    @endif
                                    @if(Str::contains($product->os,'s'))
                                        <i class="fa fa-mobile"></i>
                                    @endif
                                @endif
                              </div>
                              <div class="position-relative">
                                <?php $cats = []; foreach ($product->categories as $cat) { array_push($cats, $cat->name); } ?>
                                <span class="item_genre small fw-600">@if (!empty($cats)) {{ implode(', ',$cats) }} @endif</span>
                              </div>
                            </div>
                            <div class="item_discount d-block">
                              <div class="row align-items-center h-100 no-gutters">
                                <div class="text-right text-secondary px-6">
                                  <span class="fw-600 btn bg-warning">{{ $product->start_bid_amount . currency($product->currency,false) }}</span>
                                </div>
                              </div>
                            </div>
                            <div class="item_price">
                              <div class="row align-items-center h-100 no-gutters">
                                <div class="text-right">
                                  <span class="fw-600">{{ $product->auction_start }}</span><br>
                                  <span class="fw-600">{{ $product->auction_end }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </a>
                      </div>
                      <!-- /.item -->
                      @endforeach
                    @else
                      <p style="margin: auto;">{{__('data.No accounts')}}</p>
                    @endif

                    </div>
                  </div>
                  <!-- /.tab item -->

                </div>
                <!-- /.tab panes -->

                <!-- pagination New -->
                <nav class="mt-4 pt-4 border-top border-secondary" id="ma-2-01-c" aria-label="Page navigation">
                @if (isset($new_products['pages']) && $new_products['pages'] )
                    <ul class="pagination justify-content-end">
                    <li onclick="pagination( 'new', 'prev')" class="page-item">
                        <a class="page-link" aria-label="Previous">
                        <span class="ti-angle-left small-7" aria-hidden="true"></span>
                        <span class="sr-only">{{__('data.Previous')}}</span>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $new_products['pages'] && $i <= 3; $i++)
                    <li onclick="pagination( 'new', {{ $i }})" class="page-item @if ($i==1) active @endif"><a class="page-link">{{ $i }}</a></li>
                    @endfor
                    <li onclick="pagination( 'new', 'next')" class="page-item">
                        <a class="page-link" aria-label="Next">
                        <span class="ti-angle-right small-7" aria-hidden="true"></span>
                        <span class="sr-only">{{__('data.Next')}}</span>
                        </a>
                    </li>
                    </ul>
                @endif
                </nav>
                <!-- /.pagination New -->
                
                <!-- pagination Bids -->
                <nav class="mt-4 pt-4 border-top border-secondary" style="display:none;" id="ma-2-02-c" aria-label="Page navigation">
                @if (isset($bids_products['pages']) && $bids_products['pages'])
                    <ul class="pagination justify-content-end">
                    <li onclick="pagination( 'bid', 'prev')" class="page-item">
                        <a class="page-link" aria-label="Previous">
                        <span class="ti-angle-left small-7" aria-hidden="true"></span>
                        <span class="sr-only">{{__('data.Previous')}}</span>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $bids_products['pages'] && $i <= 3; $i++)
                    <li onclick="pagination( 'bid', {{ $i }})" class="page-item @if ($i==1) active @endif"><a class="page-link">{{ $i }}</a></li>
                    @endfor
                    <li onclick="pagination( 'bid', 'next')" class="page-item">
                        <a class="page-link" aria-label="Next">
                        <span class="ti-angle-right small-7" aria-hidden="true"></span>
                        <span class="sr-only">{{__('data.Next')}}</span>
                        </a>
                    </li>
                    </ul>
                @endif
                </nav>
                <!-- /.pagination Bids -->

              </div>
              <div class="col-lg-4">
                <div class="filters border border-secondary rounded p-4">
                  <div class="input-transparent">
                    <input type="text" id="filter_search" value="" class="form-control my-3" placeholder="{{__('data.Search')}}"/>
                  </div>
                  <ul class="sidebar-nav-light-hover list-unstyled mb-0 text-unset small-3 fw-600">
                    <li class="nav-item text-light transition mb-2 active">
                      <a href="" aria-expanded="false" data-toggle="collapse" class="nav-link py-2 px-3 text-uppercase  collapsed collapser collapser-active nav-link-border">
                          <span class="p-collapsing-title">{{__('data.Price')}}</span>
                      </a>
                      <div class="collapse nav-collapse show">
                          <ul class="list-unstyled py-2">
                            <li class="nav-item">
                              <div class="nav-link py-1 px-3">
                                    <div class="custom-control custom-checkbox">
                                      <input type="radio" name="filter_price_order" id="filter_desc">
                                      <label for="filter_desc">{{__('data.High to low')}}</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                      <input type="radio" name="filter_price_order" id="filter_asc">
                                      <label for="filter_asc">{{__('data.Low to high')}}</label>
                                    </div>
                              </div>
                            </li>
                            <li class="nav-item">
                              <div class="nav-link py-2 px-3">
                                  <div class="custom-control custom-checkbox">
                                    <input type="number" placeholder="Max" value="" id="filter_max_price" style="color:#fff;background-color: #0f131e;border: #3a4048 1px solid;">
                                  </div>
                              </div>
                            </li>
                            <li class="nav-item">
                              <div class="nav-link py-2 px-3">
                                  <div class="custom-control custom-checkbox">
                                  <input type="number" placeholder="Min" value="" id="filter_min_price" style="color:#fff;background-color: #0f131e;border: #3a4048 1px solid;">
                                  </div>
                              </div>
                            </li>
                            
                          </ul>
                      </div>
                    </li>
                    <li class="nav-item text-light transition mb-2">
                      <a href="" aria-expanded="false" data-toggle="collapse" class="nav-link py-2 px-3 text-uppercase  collapsed collapser nav-link-border">
                          <span class="p-collapsing-title">{{__('data.Platform')}}</span>
                      </a>
                      <div class="collapse nav-collapse">
                          <ul class="list-unstyled py-2">
                            <li class="nav-item">
                              <div class="nav-link py-2 px-3">
                                  <div class="custom-control custom-checkbox">
                                      <label><input type="checkbox" id="filter_playstation" value="p" checked>
                                          {{__('data.Playstation')}}</label>
                                  </div>
                              </div>
                            </li>
                            <li class="nav-item">
                              <div class="nav-link py-2 px-3">
                                  <div class="custom-control custom-checkbox">
                                      <label><input type="checkbox" id="filter_xbox" value="x" checked> {{__('data.Xbox')}}</label>
                                  </div>
                              </div>
                            </li>
                            <li class="nav-item">
                              <div class="nav-link py-2 px-3">
                                  <div class="custom-control custom-checkbox">
                                      <label><input type="checkbox" id="filter_smartphone" value="s" checked> {{__('data.Smartphone')}}</label>
                                  </div>
                              </div>
                            </li>
                            <li class="nav-item">
                              <div class="nav-link py-2 px-3">
                                  <div class="custom-control custom-checkbox">
                                      <label><input type="checkbox" id="filter_other" value="o" checked> {{__('data.Other')}}</label>
                                  </div>
                              </div>
                            </li>
                          </ul>
                      </div>
                    </li>
                    <li class="nav-item text-light transition mb-2">
                      <a href="" aria-expanded="false" data-toggle="collapse" class="nav-link py-2 px-3 text-uppercase  collapsed collapser nav-link-border">
                          <span class="p-collapsing-title">{{__('data.Categories')}}</span>
                      </a>
                      <div class="collapse nav-collapse">
                          <ul class="list-unstyled py-2">
                          <?php
                              $categories = \App\Models\Category::where('is_active','=',true)->get();
                              $parents = [];
                              $childs = [];
                              foreach ( $categories as $item ) {
                                  if (!$item->parent_id) {
                                      $parents[] = $item;
                                  } else {
                                      $childs[] = $item;
                                  }
                              }
                          ?>
                          @if($parents) @foreach ($parents as $category)
                            <li class="nav-item">
                              <div class="nav-link py-2 px-3">
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input categoryCheck" type="checkbox" value="{{ $category->id }}" id="{{ $category->slug }}_check" checked>
                                    <label class="custom-control-label" for="{{ $category->slug }}_check">
                                      {{ $category->name }}
                                    </label>
                                  </div>
                              </div>
                            </li>
                            @foreach ($childs as $key => $child)
                                @if($child->parent_id == $category->id )
                                <li class="nav-item ml-5">
                                <div class="nav-link py-2 px-3">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input categoryCheck" type="checkbox" value="{{ $child->id }}" id="{{ $child->slug }}_check" checked>
                                        <label class="custom-control-label" for="{{ $child->slug }}_check">
                                        {{ $child->name }}
                                        </label>
                                    </div>
                                </div>
                                </li>
                                <?php unset($childs[$key]); ?>
                                @endif
                            @endforeach
                          @endforeach @else
                            <li class="nav-item">
                              <div class="nav-link py-2 px-3" style="text-align:center;">
                                  <label>{{__('data.There are no categories')}}</label>
                              </div>
                            </li>
                          @endif
                          </ul>
                      </div>
                    </li>
                    <li class="nav-item text-light transition mt-4">
                      <button id="ResetFilter" type="button" class="btn btn-warning d-block text-white w-100">Reset Filter</button>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>  
      </section>
      <!-- /.content area -->

    </main>
    <script src="/front/assets/js/shop_slider.js"></script>
    <script>
        if ( window.location.href.indexOf("shop#bids") != -1 ) {

            document.getElementById("mp-2-02-tab").setAttribute("aria-selected", true);
            document.getElementById("mp-2-02-tab").classList = "nav-link active show";
            document.getElementById("mp-2-02-c").classList = "tab-pane fade active show";
            document.getElementById("ma-2-02-c").style.display = "";

            document.getElementById("mp-2-01-tab").setAttribute("aria-selected", false);
            document.getElementById("mp-2-01-tab").classList = "nav-link";
            document.getElementById("mp-2-01-c").classList = "tab-pane fade";
            document.getElementById("ma-2-01-c").style.display = "none";
        }
    </script>
@stop

@if (count($best_deals))
    <!-- header -->
    <header class="header">
      <!-- content area -->
      <section class="content-section text-light br-n bs-c bp-c" style="background-image: url({{ asset('front/assets/img/bg/bg-5.jpg') }});">
        <div class="container">
          <div class="header text-left">
            <h2>Best Deals</h2>
          </div>
          <div id="storeCarousel" class="carousel-spotlight carousel slide" data-ride="carousel">
            <div class="carousel-inner">

            @foreach ($best_deals as $key => $post)
            <?php $product_images = \App\Models\ProductImage::where('product_id','=',$post->id)->get(); ?>
              <!-- carousel item -->
              <div class="carousel-item @if($key==0) active @endif">
                <div class="row">
                  <div class="col-lg-8 pr-lg-1">
                    <a href="{{ URL( '/product/' . $post->slug) }}">
                      <div class="d-flex h-100 bs-c br-n bp-c ar-8_5 position-relative" style="background-image: url({{ URL('/uploads/images/products/'.$post->main_image) }});">
                      </div>
                    </a>
                  </div>
                  <div class="col-lg-4 d-none d-lg-block pl-lg-1">
                    <div class="row no-gutters h-100">
                      <div class="col-12 pb-1">
                      <?php $url = count($product_images) ? URL('/uploads/images/products/'. $product_images[0]->name) :URL('/uploads/images/products/'.$post->main_image); ?>
                        <a href="{{ URL( '/product/' . $post->slug) }}">
                          <div class="d-flex h-100 bs-c br-n bp-c position-relative" style="background-image: url({{ $url }});"></div>
                        </a>
                      </div>
                      <div class="col-12 pt-1">
                      <?php $url = count($product_images) > 1 ? URL('/uploads/images/products/'. $product_images[1]->name) :URL('/uploads/images/products/'.$post->main_image); ?>
                        <a href="{{ URL( '/product/' . $post->slug) }}">
                          <div class="d-flex h-100 bs-c br-n bp-c position-relative" style="background-image: url({{ $url }});"></div>
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="bg-dark d-flex p-4">
                      <div class="flex-1 d-flex align-items-center">
                        <h5 class="mb-0"><a href="{{ URL( '/product/' . $post->slug) }}">{{ $post->name }}</a></h5>
                      </div>
                      <div class="price d-none d-md-flex flex-wrap align-items-center">
                        <div class="px-3 py-1 my-md-3 my-lg-0 bg-warning text-secondary rounded"><span class="fw-600">@if($post->price) {{ $post->price }} @else {{ $post->start_bid_amount }} <i class="fas fa-clock"></i> @endif</span></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.carousel item -->
            @endforeach

            </div>

            <!-- left and right controls -->
            <a class="carousel-control-prev light" href="#storeCarousel" data-slide="prev">
              <span class="icon-cl-prev pe-7s-angle-left lead-6 px-2 py-2"></span>
            </a>
            <a class="carousel-control-next light" href="#storeCarousel" data-slide="next">
              <span class="icon-cl-next pe-7s-angle-right lead-6 px-2 py-2"></span>
            </a>
            <!-- /.left and right controls -->

            <!-- indicators -->
            <ul class="carousel-indicators indicators-square">
            @for ($i=0;$i<count($best_deals);$i++)
              <li data-target="#storeCarousel" data-slide-to="{{ $i }}" @if($i==0) class="active" @endif></li>
            @endfor
            </ul>
            <!-- /.indicators -->

          </div>
        </div>
      </section>
      <!-- /.content area -->
    </header>
    <!-- /.header -->
@endif

@extends('front.layouts.master')
@section('title', __('front.about'))
@section('content')
    <main class="main-content">

      <!-- content area -->
      <section class="content-section testimonial-section text-center bg-warning" data-overlay="2">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 mx-auto">
              <div class="text-light">
                <h2 class="mb-3">{{ __('front.about') }}</h2>
                <p class="mb-0 lead-1">منصة اعتمد هي منصة محلية توفر خدمات بيع حسابات الألعاب بجميع أنواعها كما تتميز منصة اعتمد بالسرية والأمان في جميع عمليات البيع من خلال فريق عمل متكامل هدفهم الأسمي وليس الوحيد هو منع جميع العمليات المشبوهة ومحاولات السرقة من خلال التحقق من جميع الحسابات وكلمات السر مع إنجاز هذا العمل في وقت قصير جداً مع دعم علي مدار الساعة طوال أيام الأسبوع وأيضاً تقدم خيارات كثيرة للدفع داخل المملكة العربية السعودية وخارجها ، ومعاً لتجربة مستخدم أفضل</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /.content area -->
      
      <!-- content area -->
      <div class="about-features content-section bp-c br-n bs-c" style="background-image: url({{ asset('front/assets/img/bg/bg_a.jpg') }})" data-overlay="8">
        <div class="container-fluid text-center">
          <div class="row gutters-y">
            <div class="col-md-6 col-lg-3 mb-6 mb-lg-0">
              <div class="display-4 mb-6 text-warning">
                <i class="fas fa-users"></i>
              </div>
              <div class="d-block counter-total lh-1 fw-600 mb-3">6</div>
              <span class="lead-1 fw-600 text-uppercase">Total Players</span>
            </div>
            <div class="col-md-6 col-lg-3 mb-6 mb-lg-0">
              <div class="display-4 mb-6 text-warning">
                <i class="fas fa-trophy"></i>
              </div>
              <div class="d-block counter-total lh-1 fw-600 mb-3">5</div>
              <span class="lead-1 fw-600 text-uppercase">Won awards</span>
            </div>
            <div class="col-md-6 col-lg-3 mb-6 mb-md-0">
              <div class="display-4 mb-6 text-warning">
                <i class="fas fa-heart"></i>
              </div>
              <div class="d-block counter-total lh-1 fw-600 mb-3">10</div>
              <span class="lead-1 fw-600 text-uppercase">Happy Players</span>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="display-4 mb-6 text-warning">
                <i class="fas fa-globe-americas"></i>
              </div>
              <div class="d-block counter-total lh-1 fw-600 mb-3">2</div>
              <span class="lead-1 fw-600 text-uppercase">Countries</span>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content area -->

    </main>
@stop

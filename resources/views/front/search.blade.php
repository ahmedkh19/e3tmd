@extends('front.layouts.master')
@section('title', "search > " . $search )
@section('search', $search )
@section('content')
    <!-- search content -->
    <style>
        .zoom {
            transition: transform 1s;
        }
        .zoom:hover {
            transform: scale(1.04); 
        }
        
    </style>
    <section class="container my-5">
        <div class="row">
        @if ($error_search)
            <span class="alert alert-error">{{ $error_search }}</span>
        @else
            @if(count($results))
                @foreach($results as $result)
                @if ($type == 'accounts')
                <!--card-->
                <div class="col-12 col-ms-6 col-md-4 col-lg-3 p-3">
                    <div class=" p-0 border">
                        <a href="{{ URL( '/product/' . $result->slug) }}" target="_blank" class="w-100">
                            <div class="zoom w-100 p-2">
                            <img class="w-100" style="height:250px" src="{{ URL( '/uploads/images/products/' . $result->main_image) }}"/>
                            </div>
                        </a>
                        <div class="px-3">
                            <h4 class="owl_item_title text-lt text-white"><a target="_blank" href="{{ URL( '/product/' . $result->slug) }}">{{ $result->name }}</a></h4>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bolder text-lt">{{ $result->categories }}</span>
                                <span class="fw-bolder text-success text-lt">{{ $result->price ? $result->price . currency($result->currency,false): $result->start_bid_amount . currency($result->currency,false); }}</span>
                            </div>
                        <div class="my-2 small text-info">
                            <div><i class="fas fa-clock  mr-1"></i> <span> {{ date('d M Y', strtotime($result->created_at)); }}</span></div>
                        </div>
                        <div class="text-danger">@if ($result->auction_end) <i class="fas fa-hourglass"> {{ $result->auction_end }}</i> @else <i class="fas fa-eye"> {{ $result->viewed }}</i> @endif</div>
                        </div>
                    </div>
                </div>
                <!--card-->
                @else
                <div class="col-12 col-ms-6 col-md-4 col-lg-3 p-3">
                    <div class=" p-0">
                        <a href="{{ URL( '/user/' .  $result->username ) }}" target="_blank" class="">
                            <div class="zoom w-100 p-2 d-flex flex-column justify-content-center align-items-center">
                            <img class="rounded-circle" style="height:200px;weight:200px" src="{{ $result->avatar ? URL('/uploads/images/avatars/' . $result->avatar ): URL('/uploads/images/avatars/user.jpg'); }}"/>
                            <h4 class="text-center">{{ $result->name }}</h4>
                            </div>
                        </a>
                    </div>
                </div>
                @endif
                @endforeach
            @else
            <span class="alert alert-error">No Results Found</span>
            @endif
        @endif
        </div>
    </section>

    <section class="container my-5">
    @if (!$error_search)
        @if ($pagenate)
        <?php
            $before = $one = $two = $three = $next = 0;
            if ( (1<=$page) && ($page<=$pagenate) ) {
                if ($page == $pagenate && $page == 1) {
                    $before = 0;
                    $one = 1;
                    $two = 0;
                    $three = 0;
                    $next = 0;
                } else if ( $page == $pagenate && $page == 2 ) {
                    $before = $page - 1;
                    $one = $page - 1;
                    $two = 2;
                    $three = 0;
                    $next = 0;
                } else if ( $page < $pagenate && $page == 1 ) {
                    $before = 0;
                    $one = 1;
                    $two = (2<=$pagenate) ? 2: 0;
                    $three = (3<=$pagenate) ? 3: 0;
                    $next = (2<=$pagenate) ? 2: 0;
                } else if ($page == $pagenate && $pagenate > 3) {
                    $before = $page - 1;
                    $one = $page - 2;
                    $two = $page - 1;
                    $three = $page;
                    $next = 0;
                } else if ( $pagenate != 3 ) {
                    $before = $page - 1;
                    $one = $page - 1;
                    $two = $page;
                    $three = ($page + 1 <= $pagenate) ? $page + 1: 0;
                    $next = ($page + 1 <= $pagenate) ? $page + 1: 0;
                } else if ( ($pagenate == 3) && ($page == 3) ) {
                    $before = $page - 1;
                    $one = $page - 2;
                    $two = $page - 1;
                    $three = $page;
                    $next = 0;
                } else {
                    $before = $page - 1;
                    $one = $page - 1;
                    $two = $page;
                    $three = $page + 1;
                    $next = $page + 1;
                }
            } else {
                $before = 0;
                $one = 1;
                $two = (2<=$pagenate) ? 2: 0;
                $three = (3<=$pagenate) ? 3: 0;
                $next = (2<=$pagenate) ? 2: 0;
            }
        ?>
        <nav class="mt-4 pt-4 border-top border-secondary" id="ma-2-01-c" aria-label="Page navigation">
           <ul class="pagination justify-content-end">
                <li class="page-item">
                    <a @if($before) href="{{ URL('/search?search=' . $search. '&type='. $type . '&page=' . $before) }}" @endif class="page-link" aria-label="Previous">
                    <span class="ti-angle-left small-7" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                    </a>
                </li>
                @if($one) <li class="page-item @if($one == $page) active @endif"><a href="{{ URL('/search?search=' . $search. '&type='. $type . '&page=' . $one) }}" class="page-link">{{ $one }}</a></li> @endif
                @if($two) <li class="page-item @if($two == $page) active @endif"><a href="{{ URL('/search?search=' . $search. '&type='. $type . '&page=' . $two) }}" class="page-link">{{ $two }}</a></li> @endif
                @if($three) <li class="page-item @if($three == $page) active @endif"><a href="{{ URL('/search?search=' . $search. '&type='. $type . '&page=' . $three) }}" class="page-link">{{ $three }}</a></li> @endif
                <li class="page-item">
                    <a @if($next) href="{{ URL('/search?search=' . $search. '&type='. $type . '&page=' . $next) }}" @endif class="page-link" aria-label="Next">
                    <span class="ti-angle-right small-7" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
        @endif
    @endif
    </section>
    <!-- !search content -->
@stop

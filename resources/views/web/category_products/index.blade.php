@extends('layouts.template')

@section('title', 'Home')
@section('description', 'Home Description')

@section('page_level_css')
@endsection

@section('content')
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url(../front/images/bg/blinds_banner-1024x429.jpg) no-repeat scroll center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Shop Page</h2>
                        <nav class="bradcaump-inner">
                          <a class="breadcrumb-item link-primary" href="index.html">Home</a>
                          <span class="brd-separetor">/</span>
                          <span class="breadcrumb-item active">Shop Page</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <section class="htc__product__area shop__page ptb--50 bg__white">
        <div class="container">
            <div class="htc__product__container">
                <!-- Start Product MEnu -->
                <div class="row">

                    <div class="col-md-8">
                        <!-- Start Filter Menu -->
                        <div class="filter__wrap">
                            <div class="filter__cart">
                                <div class="filter__cart__inner">
                                    <div class="filter__menu__close__btn">
                                        <a href="#"><i class="zmdi zmdi-close link-primary"></i></a>
                                    </div>
                                    <div class="filter__content">
                                        <!-- Start Single Content -->
                                        <div class="fiter__content__inner">
                                            <div class="single__filter">
                                                <h2>Categories</h2>
                                                <ul class="filter__list">
                                                    @if(!$storeProductCategory->isEmpty())
                                                        @foreach($storeProductCategory as $storeCatObj)
                                                    <li><input type="checkbox"/><a class="ml-3 link-secondary" data-filter=".cat--1" href="#default">{{ucfirst($storeCatObj->name)}}</a></li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                            <div class="single__filter">
                                                <h2>Price</h2>
                                                <ul class="filter__list">
                                                    <li><a class="link-secondary" href="#">$0.00 - $50.00</a></li>
                                                    <li><a class="link-secondary" href="#">$50.00 - $100.00</a></li>
                                                    <li><a class="link-secondary" href="#">$100.00 - $150.00</a></li>
                                                    <li><a class="link-secondary" href="#">$150.00 - $200.00</a></li>
                                                    <li><a class="link-secondary" href="#">$300.00 - $500.00</a></li>
                                                    <li><a class="link-secondary" href="#">$500.00 - $700.00</a></li>
                                                </ul>
                                            </div>
                                            <div class="single__filter">
                                                <h2>Color</h2>
                                                <ul class="filter__list sidebar__list">
                                                    @if(!$storeProductColor->isEmpty())
                                                        @foreach($storeProductColor as $storeColorObj)
                                                    <li class="black"><input type="checkbox"/><a class="ml-3 link-secondary" href="#">Black</a></li>
                                                        @endforeach

                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- End Single Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Filter Menu -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <div class="sidebar left-sidebar">
                            <div class="cust_cart_box s-side-text">
                                <div class="sidebar-title clearfix">
                                    <h3 class="floatleft h7-heading text-secondary">Categories</h3>
                                </div>
                                <hr class="line-divider">
                                <!-- <div class="filter__menu__container"> -->
                                <div class="product__menu">
                                    <button data-filter="*"  class="is-checked text-primary width-100 text-left pl-0">All</button>
                                    @if(!($storeProductCategory->isEmpty()))
                                        @foreach ($storeProductCategory as $catObj)
                                        <button class="link-dark width-100 text-left pl-0 store_categories" data-id="{{$catObj->id}}" data-filter=".cat--1">{{$catObj->name}}</button>
                                        @endforeach
                                    @endif

                                </div>
                                <!-- </div> -->
                            </div>
                            <div class="cust_cart_box s-side-text mt--40">
                                <div class="sidebar-title clearfix">
                                    <h3 class="floatleft h7-heading text-secondary">Price</h3>
                                </div>
                                <hr class="line-divider">
                                <div class="range-slider clearfix">
                                    <form action="#" method="get">
                                        <label><span>You range</span> <input class="padding-1 border-0" type="text" id="amount" readonly=""></label>
                                        <div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 67.5%;"></div><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 0%;"></span><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 67.5%;"></span></div>
                                    </form>
                                </div>
                            </div>
                            <div class="cust_cart_box s-side-text mt--40">
                                <div class="sidebar-title clearfix">
                                    <h3 class="floatleft h7-heading text-secondary">Color</h3>
                                </div>
                                <div class="single__filter">
                                    <ul class="filter__list sidebar__list">
                                            @if(!$storeProductColor->isEmpty())
                                                @foreach($storeProductColor as $storeColorObj)
                                            <li class="black"><input type="checkbox"/><a class="link-secondary ml-3" href="#">{{ucfirst($storeColorObj->name)}}</a></li>
                                                @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <div class="right-products">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="section-title clearfix">
                                        <ul>
                                            <li class="text-right">
                                                <div class="filter__box">
                                                    <a class="filter__menu link-primary" href="#">filter</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- End Product MEnu -->
                            <div class="row">
                                <div class="product__list another-product-style">
                                    <!-- Start Single Product -->
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    @if(!($products->isEmpty()))
                                    @foreach ($products as $productObj)
                                    <div class="col-md-3 single__pro col-lg-3 col-sm-4 col-xs-12 cat--3">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('product/coverimage').'/'.$productObj->main_image }}" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action border-normal bg-primary">
                                                        <li><a data-toggle="modal" data-target="#productModal" title="Quick View" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
                                                        <li><a title="Add TO Cart" href="cart.html"><span class="ti-shopping-cart"></span></a></li>
                                                        <li><a title="Wishlist" href="wishlist.html"><span class="ti-heart"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2><a class="link-secondary" href="product-details.html">{{$productObj->name}}</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    {{-- <div class="col-md-3 single__pro col-lg-3 col-sm-4 col-xs-12 cat--4">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/11.png') }}" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action border-normal bg-primary">
                                                        <li><a data-toggle="modal" data-target="#productModal" title="Quick View" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
                                                        <li><a title="Add TO Cart" href="cart.html"><span class="ti-shopping-cart"></span></a></li>
                                                        <li><a title="Wishlist" href="wishlist.html"><span class="ti-heart"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2><a class="link-secondary" href="product-details.html">Unero Round Sunglass</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    <div class="col-md-3 single__pro col-lg-3 col-sm-4 col-xs-12 cat--3">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/12.png') }}" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action border-normal bg-primary">
                                                        <li><a data-toggle="modal" data-target="#productModal" title="Quick View" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
                                                        <li><a title="Add TO Cart" href="cart.html"><span class="ti-shopping-cart"></span></a></li>
                                                        <li><a title="Wishlist" href="wishlist.html"><span class="ti-heart"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2><a class="link-secondary" href="product-details.html">Unero Small Bag</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    <div class="col-md-3 single__pro col-lg-3 col-sm-4 col-xs-12 cat--3">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/13.png') }}" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action border-normal bg-primary">
                                                        <li><a data-toggle="modal" data-target="#productModal" title="Quick View" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
                                                        <li><a title="Add TO Cart" href="cart.html"><span class="ti-shopping-cart"></span></a></li>
                                                        <li><a title="Wishlist" href="wishlist.html"><span class="ti-heart"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2><a class="link-secondary" href="product-details.html">Wood Complex Lamp Box</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    <div class="col-md-3 single__pro col-lg-3 col-sm-4 col-xs-12 cat--4">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/14.png') }}" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action border-normal bg-primary">
                                                        <li><a data-toggle="modal" data-target="#productModal" title="Quick View" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
                                                        <li><a title="Add TO Cart" href="cart.html"><span class="ti-shopping-cart"></span></a></li>
                                                        <li><a title="Wishlist" href="wishlist.html"><span class="ti-heart"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2><a class="link-secondary" href="product-details.html">Wood Long TV Board</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    <div class="col-md-3 single__pro col-lg-3 col-sm-4 col-xs-12 cat--4">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/15.png') }}" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action border-normal bg-primary">
                                                        <li><a data-toggle="modal" data-target="#productModal" title="Quick View" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
                                                        <li><a title="Add TO Cart" href="cart.html"><span class="ti-shopping-cart"></span></a></li>
                                                        <li><a title="Wishlist" href="wishlist.html"><span class="ti-heart"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2><a class="link-secondary" href="product-details.html">Wood Simple Chair V2</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    <div class="col-md-3 single__pro col-lg-3 hidden-sm col-xs-12 cat--3">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/16.png') }}" alt="product images">
                                                    </a>
                                                </div>
                                                <div class="product__hover__info">
                                                    <ul class="product__action border-normal bg-primary">
                                                        <li><a data-toggle="modal" data-target="#productModal" title="Quick View" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
                                                        <li><a title="Add TO Cart" href="cart.html"><span class="ti-shopping-cart"></span></a></li>
                                                        <li><a title="Wishlist" href="wishlist.html"><span class="ti-heart"></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product__details">
                                                <h2><a class="link-secondary" href="product-details.html">Wood Simple Clock</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <!-- End Single Product -->
                                </div>
                            </div>
                            <!-- Start Load More BTn -->
                            <div class="row mt--60">
                                <div class="col-md-12">
                                    <div class="htc__loadmore__btn">
                                        <a class="btn-primary" href="#">load more</a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Load More BTn -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page_level_js')
    <script src="{{ asset('front/js/plugins.js') }}"></script>
    <script src="{{ asset('front/js/slick.min.js') }}"></script>
    <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>


@endsection

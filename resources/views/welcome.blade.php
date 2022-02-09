@extends('layouts.template')

@section('title', 'Home')
@section('description', 'Home Description')

@section('page_level_css')
<style>
    .mySlides {
        display: none
    }
    img {
        vertical-align: middle;
        max-height: 500px;
    }
    .slideshow-container {
        max-width: 100%;
        position: relative;
        margin: auto;
    }
    /* Next & previous buttons */
    .prev,
    .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        width: auto;
        padding: 16px;
        margin-top: -22px;
        color: white;
        font-weight: bold;
        font-size: 18px;
        transition: 0.6s ease;
        border-radius: 0 3px 3px 0;
        user-select: none;
    }
    /* Position the "next button" to the right */
    .next {
        right: 0;
        border-radius: 3px 0 0 3px;
    }
    /* On hover, add a black background color with a little bit see-through */
    .prev:hover,
    .next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }
    /* Caption text */
    .text {
        color: #ffffff;
        font-size: 15px;
        padding: 8px 12px;
        position: absolute;
        bottom: 30%;
        width: 100%;
        text-align: center;
    }
    /* Number text (1/3 etc) */
    .numbertext {
        color: #ffffff;
        font-size: 12px;
        padding: 8px 12px;
        position: absolute;
        top: 0;
    }
    /* The dots/bullets/indicators */
    .dot {
        cursor: pointer;
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #999999;
        border-radius: 50%;
        display: inline-block;
        transition: background-color 0.2s ease;
    }
    .active,
    .dot:hover {
        background-color: #111111;
    }
    /* Fading animation */
    .fade {
        -webkit-animation-name: fade;
        -webkit-animation-duration: 5.5s;
        animation-name: fade;
        animation-duration: 5.5s;
    }
    @-webkit-keyframes fade {
        from {
        opacity: .5;
        }
        to {
        opacity: 1
        }
    }
    @keyframes fade {
        from {
        opacity: .5
        }
        to {
        opacity: 1
        }
    }
    @media only screen and (max-width: 720px) {
        .text {
            bottom: 5%;
        }
        .slideshow-container {
            height: 400px;
        }
        .slideshow-container.cust-slider{
            background: #28B463 !important
        }
        .mySlides.fade img{
            display: none;
        }
    }
    /* On smaller screens, decrease text size */
    @media only screen and (max-width: 300px) {
        .prev,
        .next,
        .text {
        font-size: 11px
        }
    }
</style>
@endsection

@section('content')



<!-- Start Slider Product -->
<section class="categories-slider-area bg__white">
        <div class="container-fluid">
            <div class="row">
                <!-- Start Left Feature -->
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 float-left-style">
                    <!-- Start Slider Area -->

                    <div class="slideshow-container cust-slider">
                        <div class="mySlides fade">
                        <div class="numbertext">1 / 3</div>
                        <img src="front/images/slider/bg/1.jpg" style="width:100%">
                        <div class="text">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                                        <div class="slider__inner">
                                            <div class="card_banner">
                                                <h2 class="cust-font-bold text-left">Quality Products <span class="text-primary">Everyday<br> Always</span></h2>
                                                <p class="mt--10 text-left">This online compressor tool is browser-based and functions <br>independently from your OS. So, you can easily <br>access this tool using a Mac, Windows, or Linux.</p>
                                                <button class="mt--10 bg-primary d-flex justify-content-start">shop now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="mySlides fade">
                        <div class="numbertext">2 / 3</div>
                        <img src="front/images/slider/bg/1.jpg" style="width:100%">
                        <div class="text"><div class="container">
                                <div class="row">
                                    <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                                        <div class="slider__inner">
                                            <div class="card_banner">
                                                <h2 class="cust-font-bold text-left">Low Pricesssssssssssssssssssssss <span class="text-primary">Everyday<br> Always</span></h2>
                                                <p class="mt--10 text-left">There is only that moment and the incredible certainty<br>that everything under the sun has been written by<br>one hand only</p>
                                                <button class="mt--10 bg-primary d-flex justify-content-start">shop now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="mySlides fade">
                        <div class="numbertext">3 / 3</div>
                        <img src="front/images/slider/bg/1.jpg" style="width:100%">
                        <div class="text"><div class="container">
                                <div class="row">
                                    <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                                        <div class="slider__inner">
                                            <div class="card_banner">
                                                <h2 class="cust-font-bold text-left">Best <span class="text-primary">Price<br> And Discount Offers</span></h2>
                                                <p class="mt--10 text-left">There is only that moment and the incredible certainty<br>that everything under the sun has been written by<br>one hand only</p>
                                                <button class="mt--10 bg-primary d-flex justify-content-start">shop now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                    </div>
              <br>
        </div>
    </div>
</div>
</section>



    <!-- Start Our Product Area -->
    <section class="htc__blog__area bg__white pb--50">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="section__title section__title--2 text-center mt--70">
                        <h2 class="text-style-deco-5 text-primary">Premium Blinds</h2>
                        <h2 class="title__line text-primary">Category</h2>
                        <p>Shop Online For Window Blinds On Premium Blinds UK Made Best Online Store</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="blog__wrap clearfix mt--60 xmt-30">
                    <!-- Start Single Blog -->
                    @if(!($storeProductCategory->isEmpty()))
                    @foreach ($storeProductCategory as $storeCatObj)
                    <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                        <div class="blog foo mb--30">
                            <div class="blog__inner">
                                <div class="blog__thumb">
                                    <a href="blog-details.html">
                                        <img src="{{asset('category').'/'.$storeCatObj->image}}" alt="blog images">
                                    </a>
                                </div>
                                <div class="blog__hover__info">
                                    <div class="blog__hover__action">
                                        <h2 class="blog__des"><a class="text-white" href="{{route('getProductByCategory',$storeCatObj->id)}}">{{$storeCatObj->name}}</a></p>
                                        <ul class="bl__meta">
                                            <li><a class="text-white" href="{{route('getProductByCategory',$storeCatObj->id)}}">{{$storeCatObj->products_count}} Blinds</a></li>
                                        </ul>
                                        <div class="blog__btn">
                                            <a class="read__more__btn text-white" href="{{route('getProductByCategory',$storeCatObj->id)}}">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <!-- End Single Blog -->
                    <!-- Start Single Blog -->
                    {{-- <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
                        <div class="blog foo mb--30">
                            <div class="blog__inner">
                                <div class="blog__thumb">
                                    <a href="blog-details.html">
                                        <img src="{{asset('front/images/blog/blog-img/2.jpg')}}" alt="blog images">
                                    </a>
                                </div>
                                <div class="blog__hover__info">
                                    <div class="blog__hover__action">
                                        <h2 class="blog__des"><a class="text-white" href="#">Roller Blinds</a></p>
                                        <ul class="bl__meta">
                                            <li><a class="text-white" href="#">29 Blinds</a></li>
                                        </ul>
                                        <div class="blog__btn">
                                            <a class="read__more__btn text-white" href="blog-details.html">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Blog -->
                    <!-- Start Single Blog -->
                    <div class="col-md-4 col-lg-4 hidden-sm col-xs-12">
                        <div class="blog foo mb--30">
                            <div class="blog__inner">
                                <div class="blog__thumb">
                                    <a href="blog-details.html">
                                        <img src="{{asset('front/images/blog/blog-img/3.jpg')}}" alt="blog images">
                                    </a>
                                </div>
                                <div class="blog__hover__info">
                                    <div class="blog__hover__action">
                                        <h2 class="blog__des"><a class="text-white" href="#">Roller Blinds</a></p>
                                        <ul class="bl__meta">
                                            <li><a class="text-white" href="#">29 Blinds</a></li>
                                        </ul>
                                        <div class="blog__btn">
                                            <a class="read__more__btn text-white" href="blog-details.html">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Blog -->
                    <!-- Start Single Blog -->
                    <div class="col-md-4 col-lg-4 hidden-sm col-xs-12">
                        <div class="blog foo mb--30">
                            <div class="blog__inner">
                                <div class="blog__thumb">
                                    <a href="blog-details.html">
                                        <img src="{{asset('front/images/blog/blog-img/3.jpg')}}" alt="blog images">
                                    </a>
                                </div>
                                <div class="blog__hover__info">
                                    <div class="blog__hover__action">
                                        <h2 class="blog__des"><a class="text-white" href="#">Roller Blinds</a></p>
                                        <ul class="bl__meta">
                                            <li><a class="text-white" href="#">29 Blinds</a></li>
                                        </ul>
                                        <div class="blog__btn">
                                            <a class="read__more__btn text-white" href="blog-details.html">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Blog -->
                    <!-- Start Single Blog -->
                    <div class="col-md-4 col-lg-4 hidden-sm col-xs-12">
                        <div class="blog foo mb--30">
                            <div class="blog__inner">
                                <div class="blog__thumb">
                                    <a href="blog-details.html">
                                        <img src="{{asset('front/images/blog/blog-img/3.jpg')}}" alt="blog images">
                                    </a>
                                </div>
                                <div class="blog__hover__info">
                                    <div class="blog__hover__action">
                                        <h2 class="blog__des"><a class="text-white" href="#">Roller Blinds</a></p>
                                        <ul class="bl__meta">
                                            <li><a class="text-white" href="#">29 Blinds</a></li>
                                        </ul>
                                        <div class="blog__btn">
                                            <a class="read__more__btn text-white" href="blog-details.html">Shop Now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <!-- End Single Blog -->
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="htc__product__area shop__page ptb--50 bg__white">
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
                                                    <li><input type="checkbox"/><a class="ml-3 link-secondary" data-filter=".cat--1" href="#default">ROLLER BLINDS</a></li>
                                                    <li><input type="checkbox"/><a class="ml-3 link-secondary" data-filter=".cat--2" href="#accessories">ROMAN BLINDS</a></li>
                                                    <li><input type="checkbox"/><a class="ml-3 link-secondary" data-filter=".cat--3" href="#bags">VERTICAL BLINDS</a></li>
                                                    <li><input type="checkbox"/><a class="ml-3 link-secondary" data-filter=".cat--4" href="#chair">VENETIAN BLINDS</a></li>
                                                    <li><input type="checkbox"/><a class="ml-3 link-secondary" data-filter=".cat--1" href="#decoration">WOOD BLINDS</a></li>
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
                                                    <li class="black"><input type="checkbox"/><a class="ml-3 link-secondary" href="#">Black</a></li>
                                                    <li class="blue"><input type="checkbox"/><a class="ml-3 link-secondary" href="#">Blue</a></li>
                                                    <li class="brown"><input type="checkbox"/><a class="ml-3 link-secondary" href="#">Brown</a></li>
                                                    <li class="red"><input type="checkbox"/><a class="ml-3 link-secondary" href="#">Red</a></li>
                                                    <li class="orange"><input type="checkbox"/><a class="ml-3 link-secondary" href="#">Orange</a></li>
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
                                    <button class="link-primary width-100 text-left pl-0" data-filter=".cat--1">ROLLER BLINDS</button>
                                    <button class="link-primary width-100 text-left pl-0" data-filter=".cat--2">ROMAN BLINDS</button>
                                    <button class="link-primary width-100 text-left pl-0" data-filter=".cat--3">VERTICAL BLINDS</button>
                                    <button class="link-primary width-100 text-left pl-0" data-filter=".cat--4">WOOD BLINDS</button>
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
                                        <li class="black"><input type="checkbox"/><a class="link-secondary ml-3" href="#">Black</a></li>
                                        <li class="blue"><input type="checkbox"/><a class="link-secondary ml-3" href="#">Blue</a></li>
                                        <li class="brown"><input type="checkbox"/><a class="link-secondary ml-3" href="#">Brown</a></li>
                                        <li class="red"><input type="checkbox"/><a class="link-secondary ml-3" href="#">Red</a></li>
                                        <li class="orange"><input type="checkbox"/><a class="link-secondary ml-3" href="#">Orange</a></li>
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
                                    <div class="col-md-3 single__pro col-lg-3 cat--1 col-sm-4 col-xs-12">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/1.png') }}" alt="product images">
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
                                                <h2><a class="link-secondary" href="product-details.html">Simple Black Clock</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    <div class="col-md-3 single__pro col-lg-3 cat--1 col-sm-4 col-xs-12">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/2.png') }}" alt="product images">
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
                                                <h2><a class="link-secondary" href="product-details.html">BO&Play Wireless Speaker</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    <div class="col-md-3 single__pro col-lg-3 col-sm-4 col-xs-12 cat--2">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/3.png') }}" alt="product images">
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
                                                <h2><a class="link-secondary" href="product-details.html">Brone Candle</a></h2>
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
                                                        <img src="{{ asset('front/images/product/4.png') }}" alt="product images">
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
                                                <h2><a class="link-secondary" href="product-details.html">Brone Lamp Glasses</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    <div class="col-md-3 single__pro col-lg-3 cat--1 col-sm-4 col-xs-12 cat--2">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/5.png') }}" alt="product images">
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
                                                <h2><a class="link-secondary" href="product-details.html">Clothes Boxed</a></h2>
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
                                                        <img src="{{ asset('front/images/product/6.png') }}" alt="product images">
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
                                                <h2><a class="link-secondary" href="product-details.html">Liquid Unero Ginger Lily</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    <div class="col-md-3 single__pro col-lg-3 col-sm-4 col-xs-12 cat--2">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/7.png') }}" alt="product images">
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
                                                <h2><a class="link-secondary" href="product-details.html">Miliraty Backpack</a></h2>
                                                <ul class="product__price">
                                                    <li class="old__price">$16.00</li>
                                                    <li class="new__price text-primary">$10.00</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                    <!-- Start Single Product -->
                                    <div class="col-md-3 single__pro col-lg-3 col-sm-4 col-xs-12 cat--2">
                                        <div class="product foo">
                                            <div class="product__inner">
                                                <div class="pro__thumb">
                                                    <a href="#">
                                                        <img src="{{ asset('front/images/product/8.png') }}" alt="product images">
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
                                                <h2><a class="link-secondary" href="product-details.html">Saved Wines Corkscrew</a></h2>
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
                                                        <img src="{{ asset('front/images/product/9.png') }}" alt="product images">
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
                                                <h2><a class="link-secondary" href="product-details.html">Simple Fabric Bags</a></h2>
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
                                                        <img src="{{ asset('front/images/product/10.png') }}" alt="product images">
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
                                                <h2><a class="link-secondary" href="product-details.html">Simple Fabric Chair</a></h2>
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
                                    </div>
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



                            <!-- <div class="row">
                                <div class="col-sm-12">
                                    <div class="pagnation-ul">
                                        <ul class="clearfix">
                                            <li><a href="#"><i class="mdi mdi-menu-left"></i></a></li>
                                            <li><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li><a href="#">...</a></li>
                                            <li><a href="#">10</a></li>
                                            <li><a href="#"><i class="mdi mdi-menu-right"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- End Our Product Area -->
@endsection

@section('page_level_js')
<script>
    $( document ).ready(function() {
        
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            for(i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
            }
            slideIndex++;
            if(slideIndex > slides.length) {
            slideIndex = 1
            }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 6000); // Change image every 2 seconds
        }
    });
</script>
    <script src="{{ asset('front/js/plugins.js') }}"></script>
    <script src="{{ asset('front/js/slick.min.js') }}"></script>
    <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
@endsection

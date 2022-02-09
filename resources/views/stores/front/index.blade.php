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
    <!-- Start Bradcaump area -->

    <section class="categories-slider-area bg__white">
        <div class="container-fluid">
            <div class="row">
                <!-- Start Left Feature -->
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 p--0">
                    <!-- Start Slider Area -->

                    <div class="slideshow-container cust-slider">
                        @if(!$storeCoverImages->isEmpty())
                            @foreach($storeCoverImages as $cover)
                        <div class="mySlides fade">
                            <div class="numbertext">1 /{{count($storeCoverImages)}}</div>
                            <img src="{{asset($cover->image)}}" style="width:100%">
                            <div class="text">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                                            <div class="slider__inner">
                                                <div class="card_banner">
                                                    @php
                                                        $message = explode(' ', $storeSetting->banner_title, 4);
                                                        $firstone=isset($message[0]) && !empty($message[0]) ? $message[0] : '';
                                                        $secondone=isset($message[1]) && !empty($message[1]) ? $message[1] : '';
                                                        $thirdone=isset($message[2]) && !empty($message[2]) ? $message[2] : '';
                                                    @endphp
                                                    <h2 class="cust-font-bold text-left">{{$firstone.' '.$secondone.' '}}<span class="text-primary">{{$thirdone}}<br>{{isset($message[3]) && !empty($message[3]) ? $message[3] : ''}}</span></h2>
                                                    <p class="mt--10 text-left">{{$storeSetting->banner_description}}.</p>
                                                    <button class="mt--10 bg-primary d-flex justify-content-start">shop now</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @endforeach
                        @else
                             <div class="mySlides">
                                <div class="numbertext">1 / 1</div>
                                 <img src="{{asset('front/images/slider/bg/2.jpg')}}" style="width:100%">
                             </div>
                         @endif
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </section>
    <!-- End Bradcaump area -->
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
                                                <h2 class="blog__des"><a class="text-white" href="{{route('store.categorie.product',[$storeCatObj->id])}}">{{$storeCatObj->name}}</a></h2>
                                                    <ul class="bl__meta">
                                                        <li><a class="text-white" href="{{route('store.categorie.product',[$storeCatObj->id])}}">{{$storeCatObj->products_count}} Blinds</a></li>
                                                    </ul>
                                                    <div class="blog__btn">
                                                        <a class="read__more__btn text-white" href="{{route('store.categorie.product', $storeCatObj->id)}}">Shop Now</a>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
                @endif

                </div>
            </div>
        </div>
    </section>

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

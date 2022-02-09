@extends('layouts.template')

@section('title', 'Home')
@section('description', 'Home Description')

@section('page_level_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">

    <style>
        input[type=checkbox] {
            display: none;
        }
        input[type=checkbox] + label {
            height: 12px;
            width: 12px;
            display: inline-block;
            padding: 9px;
        }
        input[type=checkbox] + label:before {
            content: url({{asset('front/images/bg/heart-unfill-icon.png')}});
            display: inline-block;
            font-size: inherit;
            text-rendering: auto;
        }
        input[type=checkbox]:checked + label:before {
            content: url({{asset('front/images/bg/heart-fill-icon.png')}});
            display: inline-block;
            font-size: inherit;
            text-rendering: auto;
        }
        .cust-wislist-text-pro{
            position: absolute;
            margin-top: 7px;
        }
    </style>

@endsection

@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url({{asset('product/coverimage').'/'.$singleProduct->main_image}}) no-repeat scroll center center / cover ;">
        <div class="ht__bradcaump__wrap">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="bradcaump__inner text-center">
                            <h2 class="bradcaump-title">{{ucfirst($singleProduct->name)}}</h2>
                            <nav class="bradcaump-inner">
                                <a class="breadcrumb-item link-primary" href="index.html">Home</a>
                                <span class="brd-separetor">/</span>
                                <span class="breadcrumb-item active">Product Details</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Bradcaump area -->

    <!-- Start Product Details -->
    <section class="htc__product__details pt--120 pb--100 bg__white">
        <div class="container">
            <div class="row">
               <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                    <div class="row mb--30">


                        <!-- Old Product View : Start  -->

                        <!-- Primary carousel image -->
                        <div class="show" href="{{asset('product/coverimage').'/'.$singleProduct->main_image}}">
                            <img src="{{asset('product/coverimage').'/'.$singleProduct->main_image}}" id="show-img">
                        </div>
                        <!-- Secondary carousel image thumbnail gallery -->

                        <div class="small-img">
                            <img src="{{asset('next-icon.png')}}" class="icon-left" alt="" id="prev-img">
                            <div class="small-container">
                                <div id="small-img-roll">
                                    @foreach ($singleProduct->product_images as $key => $imgObj)
                                    <img src="{{asset('product/productimages/').'/'.$imgObj->image}}" class="show-small-img" alt="">
                                    @endforeach
                                </div>
                            </div>
                            <img src="{{asset('next-icon.png')}}" class="icon-right" alt="" id="next-img">
                        </div>

                        <!-- Old Product View : End  -->

                    </div>
                </div>

                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                    <div class="product-details-right ckeckout-left-sidebar">
                        <!-- Start Checkbox Area -->
                        <div class="cust_cart_box checkout-form">
                            <div class="form-product-details checkout-form-inner">

                                <h2 class="title__line">{{ucfirst($singleProduct->name)." From "}}<span class="f-bold-6 text-primary text-center">{{"£ ".$singleProduct->sale_price}}</span></h2>

                                {{--<span class="add-to-wishlist-btn"><i class="ti-heart"></i>Add to Wishlist</span>--}}

                                <input type='checkbox' id="productck_{{$singleProduct->id}}"  @if(!empty($singleProduct->wishID)) checked @endif onclick="addWhishList({{$singleProduct->id}},{{isset($singleProduct->wishID) && $singleProduct->wishID > 0 ? $singleProduct->wishID :'-1'}})"/><label for="productck_{{$singleProduct->id}}"></label>
                                <span class="ml-4 cust-wislist-text-pro">Add to Wishlist</span>


                                <hr class="line-divider">

                                <form method="post" id="get_pricing">
                                    <div class="select-measurement-sec d-flex justify-content-between">
                                        <div class="">
                                            <input class="" type="radio" name="measure" id="flexRadioDefault1" value="mm">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                mm
                                            </label>
                                        </div>
                                        <div class="text-center">
                                            <input class="" type="radio" name="measure" id="flexRadioDefault2" value="cm" >
                                            <label class="form-check-label" for="flexRadioDefault2">
                                                cm
                                            </label>
                                        </div>
                                        <div class="text-right">
                                            <input class="" type="radio" name="measure" id="flexRadioDefault3" value="inch" checked>
                                            <label class="form-check-label" for="flexRadioDefault3">
                                                inches
                                            </label>
                                        </div>
                                    </div>

                                    <div class="single-checkout-box">
                                        <div class="input-group-measurement-sec width-100 d-flex">
                                            <span class="bg-primary"><i class="ti-arrows-vertical"></i></span>
                                            <input type="text" placeholder="min {{$singleProduct->min_order_length}}" name="height_measure" id="height_measure" required>
                                        </div>
                                        <span class="text-danger" id="height_measure_error"></span>
                                        <div class="input-group-measurement-sec width-100 d-flex">
                                            <span class="bg-primary"><i class="ti-arrows-horizontal"></i></span>
                                            <input type="text" placeholder="min {{$singleProduct->min_order_width}}"  name="width_measure" id="width_measure" required>
                                        </div>
                                        <span class="text-danger" id="width_measure_error"></span>
                                    </div>
                                    <input id="total_price" name="total_price" type="hidden" value="">
                                    <h2 class="f-bold-6 text-primary text-center mt--10 mb--10">£<span id="get_quote_price"></span></h2>
                                    <span class="text-danger" id="prices_error"></span>
                                </form>
                                <div class="d-flex width-100">
                                    <button class="btn-primary width-100" onclick="getPrice()">Get Quotes</button>
                                </div>

                                <hr class="line-divider">
                                <form method="post" id="add_cart">
                                    <div class="cust-product-form product_page single-checkout-box select-option">
                                        <span class="text-primary"><i class="ti-info-alt"></i>Select Your fitting type</span>
                                        <div class="select-fitting-type-sec">
                                            <div class="">
                                                <input class="" type="radio" name="fitting" value="recess" id="flexRadio1">
                                                <label class="form-check-label" for="flexRadio1">
                                                    Recess
                                                </label>
                                            </div>
                                            <div class="">
                                                <input class="" type="radio" name="fitting"  value="exact" id="flexRadio2" >
                                                <label class="form-check-label" for="flexRadio2" >
                                                    Exact
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cust-product-form product_page single-checkout-box select-option">
                                        <span class="text-primary"><i class="ti-info-alt"></i>Side of Controls</span>
                                        <select name="side_control" id="side_control">
                                            <option value="">Side of Controlls</option>
                                            <option value="left">Left</option>
                                            <option value="right">Right</option>
                                        </select>
                                    </div>
                                    <div class="cust-product-form product_page single-checkout-box select-option">
                                        <span class="text-primary"><i class="ti-info-alt"></i>Chain Color</span>
                                        <select name="chain_color" id="chain_color">
                                            <option value="">Chain Color</option>
                                            <option value="white">White</option>
                                            <option value="black">Black</option>
                                        </select>
                                    </div>
                                    <div class="cust-product-form product_page single-checkout-box select-option exact_dropdown" style="display: none;">
                                        <span class="text-primary"><i class="ti-info-alt"></i>Select your fitting option</span>
                                        <select name="set_fitting" id="set_fitting">
                                            <option value="">Fitting Option</option>
                                            <option value="bracket_to_bracket">Bracket to Bracket</option>
                                            <option value="fabric_width">Fabric Width</option>
                                        </select>
                                    </div>
                                    <!-- <div class="cust-product-form single-checkout-box">
                                        <button class="more-option-btn" type="submit">More Options</button>
                                    </div> -->
                                    <hr class="line-divider">
                                    <p class="text-center">Our price just.. </p>

                                    <p class="text-center">including FREE UK Mainland delivery today!<br>2 Roman Blind's/Total</p>

                                    <div class="mtb--20">
                                        <div>
                                            <label class="f-bold-4 border-1 border-normal padding-2"><input type="checkbox"> + Add Surefit Protection for just £7.28 per item if it turns out you made a measurements error we will replace your blind free of charge* <a href="" class="link-primary">Read More</a></label>
                                        </div>
                                    </div>
                                    <div class="d-flex width-100">
                                        <button class="btn-primary width-100" type="button" onclick="saveCart()" id="save_cart">Add To Cart</button>
                                    </div>
                            </form>
                            </div>
                        </div>
                        <!-- End Checkbox Area -->
                    </div>
                </div>



            </div>
        </div>
    </section>
    <!-- End Product Details -->
    <!-- Start Product tab -->
    <section class="cust-bg-product-page htc__product__details__tab bg-primary-light pb--60">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <div class="section__title section__title--2 text-center mt--70">
                        <h2 class="text-style-deco-5 text-primary">Premium Blinds</h2>
                        <h2 class="title__line text-primary">Products Description</h2>
                    </div>
                </div>
            </div>

            <div class="product__description__wrap mt--30">
                <div class="product__desc">
                    <h2 class="title__6">Details</h2>
                    <p>@if(!empty($singleProduct->description)){!!json_decode($singleProduct->description)!!}@endif</p>
                </div>
                <div class="pro__feature">
                    <h2 class="title__6">Features</h2>
                    <ul class="feature__list">
                        @if(!empty($singleProduct->features))
                            @foreach (unserialize($singleProduct->features) as $key=>$productObj)
                        <li><a href="#"><i class="zmdi zmdi-play-circle"></i>{{$productObj}}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- End Product tab -->
    <!---Related Products--->
    <section class="htc__product__details__tab bg__white pb--60">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <div class="section__title section__title--2 text-center mt--70">
                        <h2 class="text-style-deco-5 text-primary">Premium Blinds</h2>
                        <h2 class="title__line text-primary">RELATED products</h2>
                        <p class="text-primary">Shop Online Related Products</p>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-12"> -->
            <!-- <div class="product-style-tab"> -->

            <div class="tab-content another-product-style jump">
                <!-- <div class="tab-pane active" id="home1"> -->

                <div class="row">
                    <div class="product-slider-active owl-carousel">
                        @if(count($relatedProducts) > 0)
                            @foreach($relatedProducts as $relatedProduct)

                        <div class="col-md-3 single__pro col-lg-3 col-sm-4 col-xs-12 cat--3">
                            <div class="product">
                                <div class="product__inner">
                                    <div class="pro__thumb">
                                        <a href="{{route('store.product.detail',[$relatedProduct->id])}}">
                                            <img src="{{ asset('product/coverimage').'/'.$relatedProduct->main_image }}" alt="product images">
                                        </a>
                                    </div>
                                    <div class="product__hover__info">
                                        <ul class="product__action border-normal bg-primary">
                                            {{--<li><a data-toggle="modal" data-target="#productModal" title="Quick View" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>--}}
                                            <li><a onclick="showSingleProduct({{$relatedProduct->id}},'modal')" title="Quick View" class="quick-view modal-view detail-link"><span class="ti-plus"></span></a></li>
                                            <li><a title="Add TO Cart" href="{{route('user.viewCart',[$store->slug])}}"><span class="ti-shopping-cart"></span></a></li>
                                            <li>

                                                <input type='checkbox' id="productck_{{$relatedProduct->id}}"  @if(!empty($relatedProduct->wishID)) checked @endif onclick="addWhishList({{$relatedProduct->id}},{{isset($relatedProduct->wishID) && $relatedProduct->wishID > 0 ? $relatedProduct->wishID :'-1'}})"/><label for="productck_{{$relatedProduct->id}}"></label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="product__details">
                                    <h2><a class="link-secondary" href="{{route('store.product.detail',[$relatedProduct->id])}}">{{$relatedProduct->name}}</a></h2>
                                    <ul class="product__price">
                                       {{-- <li class="old__price">£16.00</li>--}}
                                        <li class="new__price text-primary">£{{$relatedProduct->sale_price}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- </div> -->
            </div>

            <!-- </div> -->
            <!-- </div> -->
        </div>
    </section>
<!---End Related Products--->
    <!---frequently asked question---->
    <section class="htc__product__details__tab bg__white pb--60">
        <div class="container">

            <div class="row">
                <div class="col-xs-12">
                    <div class="section__title section__title--2 text-center mt--70 mb--50">
                        <h2 class="text-style-deco-5 text-primary">Premium Blinds</h2>
                        <h2 class="title__line text-primary">Frequently Asked Questions</h2>
                    </div>
                </div>
            </div>

            <div class="accordion-wrapper">
                <div class="accordion">
                    <input class="accordion-radio" type="radio" name="radio-a" id="check1" checked>
                    <label class="accordion-label bg-primary" for="check1">What the First Step Setup Blinds ?</label>
                    <div class="accordion-content">
                        <p>Hey there, you are watching codiesbugs &#128522;</p>
                    </div>
                </div>
                <div class="accordion">
                    <input class="accordion-radio" type="radio" name="radio-a" id="check2">
                    <label class="accordion-label bg-primary" for="check2">How Long does It take to buy Blinds ?</label>
                    <div class="accordion-content">
                        <p>I hope you are enjoing the video, don't forget to give your feedback in comment section</p>
                    </div>
                </div>
                <div class="accordion">
                    <input class="accordion-radio" type="radio" name="radio-a" id="check3">
                    <label class="accordion-label bg-primary" for="check3">How much do I need for a down payment ?</label>
                    <div class="accordion-content">
                        <p>If you liked then don't forget to subscribe the channel for latest videos. </p>
                    </div>
                </div>
                <div class="accordion">
                    <input class="accordion-radio" type="radio" name="radio-a" id="check4">
                    <label class="accordion-label bg-primary" for="check4">What is a buyer's market ?</label>
                    <div class="accordion-content">
                        <p>If you liked then don't forget to subscribe the channel for latest videos. </p>
                    </div>
                </div>
                <div class="accordion">
                    <input class="accordion-radio" type="radio" name="radio-a" id="check5">
                    <label class="accordion-label bg-primary" for="check5">What is popular in  Blinds ?</label>
                    <div class="accordion-content">
                        <p>If you liked then don't forget to subscribe the channel for latest videos. </p>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!----End frequently asked question--->
@endsection
@section('page_level_js')

    <script src="{{ asset('front/js/plugins.js') }}"></script>
    <script src="{{ asset('front/js/slick.min.js') }}"></script>
    <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/js/scripts/zoom-image.js') }}"></script>
    <script src="{{ asset('front/js/scripts/main.js') }}"></script>

    <script type="text/javascript">
        @if(Session::has('error'))
            toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr.warning("{{ session('error') }}");
        @endif



        $("input[name='measure']").change(function(){
           var min_width="{{$singleProduct->min_order_width}}";
           var min_height="{{$singleProduct->min_order_length}}";
           var measure=$('input[name="measure"]:checked').val();
            $('#width_measure').val('');
            $('#height_measure').val('');
            $('#get_quote_price').text('');
            $('#total_price').val('');
           if(measure=='inch')
           {
               $("#width_measure").attr("placeholder", " ");
               $("#height_measure").attr("placeholder", " ");
               $("#width_measure").attr("placeholder","min "+min_width);
               $("#height_measure").attr("placeholder", "min "+min_height);

           }
           else if(measure=='cm'){
               $("#width_measure").attr("placeholder", " ");
               $("#height_measure").attr("placeholder", " ");
               var cmwidth=min_width * 2.54;
               var cmheight=min_height * 2.54;
               cmwidth=cmwidth.toFixed(2);
               cmheight=cmheight.toFixed(2);
               $("#width_measure").attr("placeholder","min "+cmwidth);
               $("#height_measure").attr("placeholder", "min "+cmheight);


           }
           else{
               $("#width_measure").attr("placeholder", " ");
               $("#height_measure").attr("placeholder", " ");

               var mmwidth=min_width * 25.4;
               var mmheight=min_height * 25.4;
               mmwidth=mmwidth.toFixed(2);
               mmheight=mmheight.toFixed(2);
               $("#width_measure").attr("placeholder","min "+mmwidth);
               $("#height_measure").attr("placeholder", "min "+mmheight);

           }

        });

        $("input[name='fitting']").change(function(){
            var fitting=$('input[name="fitting"]:checked').val();

            if(fitting=='exact')
            {
                $('.exact_dropdown').show();
            }
            else{
                $('.exact_dropdown').hide();
            }

        });



    </script>
@endsection

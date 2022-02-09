<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ config('app.name', 'PremiumBlindsUk') }} - @yield('title')</title>
        <meta name="description" content="@yield('description')" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--begin::Fonts-->
        <!-- Place favicon.ico in the root directory -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ !empty($storeSetting->favicon_path) ? asset($storeSetting->favicon_path) :  asset('front/images/favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('front/apple-touch-icon.png') }}">

        <!-- All css files are included here. -->
        <!-- Bootstrap fremwork main css -->
        <link rel="stylesheet" href="{{ asset('front/css/bootstrap.min.css') }}">
        <!-- Owl Carousel main css -->
        <link rel="stylesheet" href="{{ asset('front/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('front/css/owl.theme.default.min.css') }}">
        <!-- This core.css file contents all plugings css file. -->
        <link rel="stylesheet" href="{{ asset('front/css/core.css') }}">
        <!-- Theme shortcodes/elements style -->
        <link rel="stylesheet" href="{{ asset('front/css/shortcode/shortcodes.css') }}">
        <!-- Theme main style -->
        <link rel="stylesheet" href="{{ asset('front/style.css') }}">
        <!-- Responsive css -->
        <link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}">
        <!-- User style -->
        @if(!empty($storeSetting->theme_color))
        <link rel="stylesheet" href="{{ asset('front/css/'.$storeSetting->theme_color.'.css') }}">
        @else
        <link rel="stylesheet" href="{{ asset('front/css/maroon.css') }}">
        @endif
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        @yield('page_level_css')
        <!-- Modernizr JS -->
        <script src="{{ asset('front/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    </head>
    <body>
        @include('layouts.template_common.header')
        <!-- Body main wrapper start -->
        <div class="wrapper fixed__footer">
            <!-- Start Top Menu Style -->
            @include('layouts.template_common.top_menu')
            <!-- End Top Menu Style -->
            @php
            if(!empty($storeSetting->slug)){
                $k=0;
                $counts = 0;
                $carts= session()->get($storeSetting->slug);

                if(!empty($carts) && count($carts) > 0){
                     foreach($carts as $productIds => $arr){
                         if(!empty($arr)){
                         $kk = $productIds;
                         $counts++;
                     }
                     }

                }

            }

            @endphp


            <div class="custom-navbar-left">
                <ul class="menu-extra">
                    <li class="toggle__menu bg-primary"><span class="ti-menu"></span></li>
                    <li class="search search__open bg-primary"><span class="ti-search"></span></li>
                    @if(Auth::check())
                    <li class="bg-primary"><a href="{{route('userAccount',[$storeSetting->slug])}}"><span class="ti-user"></span></a></li>
                    @else
                        <li class="bg-primary"><a href="{{route('login')}}"><span class="ti-user"></span></a></li>
                    @endif
                    <li class="cart__menu bg-primary">
                        <span class="ti-shopping-cart-counter total_cart">{{!empty($counts) ? $counts  : '0'}}</span>
                        <span class="ti-shopping-cart"></span>
                    </li>
                    @if(Auth::check())
                    <li class="bg-primary"><a href="{{route('userWhishList',[$storeSetting->slug])}}">
                            {{--<span class="ti-shopping-cart-counter"></span>--}}
                            <span class="ti-heart"></span></a>
                    </li>
                    @else
                        <li class="bg-primary"><a href="{{route('login')}}">
                            {{--<span class="ti-shopping-cart-counter"></span>--}}
                                <span class="ti-heart"></span></a>
                        </li>
                    @endif
                </ul>
            </div>
            <header id="header-sec-two" class="bg-secondary padding-2">
                <!-- Start Mainmenu Area -->
                <div class="container">
                    <div class="row">
                        <!-- Start MAinmenu Ares -->
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 hidden-sm hidden-xs">
                            <p class="header-sec-two text-white"><img src="{{ asset('front/images/icons/check-icon.png') }}"> 3 Year Guarantee</p>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
                            <p class="header-sec-two text-white"><img src="{{ asset('front/images/icons/ship-icon.png') }}"> FastTrack</p>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
                            <p class="header-sec-two text-white"><img src="{{ asset('front/images/icons/gift-icon.png') }}"> FREE Sample</p>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6 hidden-sm hidden-xs">
                            <p class="header-sec-two text-white"><img src="{{ asset('front/images/icons/measure-icon.png') }}"> Add Measure Guard</p>
                        </div>
                    </div>
                </div>
                <!-- End Mainmenu Area -->
            </header>
            <div class="body__overlay"></div>
            <!-- Start Offset Wrapper -->
            @include('layouts.template_common.quick_lunch')
            <!-- End Offset Wrapper -->
            @yield('content')
            <!-- Start News Letter Area -->
            @include('layouts.template_common.news_letter')
            <!-- End News Letter Area -->
            <!-- Start Footer Area -->
            @include('layouts.template_common.footer')
            <!-- End Footer Area -->
        </div>
        <!-- Body main wrapper end -->
        <!-- QUICKVIEW PRODUCT -->
        <div id="quickview-wrapper">
            <!-- Modal -->
            <div class="modal fade" id="productModal" data-backdrop="static" tabindex="-1" role="dialog">
                <div class="modal-dialog modal__container" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" onclick="resetForm()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-product">
                                <!-- Start product images -->
                                <div class="product-images">
                                    <div class="main-image images">
                                        <img alt="big images" src="images/product/big-img/1.jpg">
                                    </div>
                                </div>
                                <!-- end product images -->
                                <div class="product-info">
                                    <!-- Start Checkbox Area -->
                                    <div class="cust_cart_box checkout-form">
                                        <div class="form-product-details checkout-form-inner">
                                            <h2 class="title__line "><span class="product_modal_title"></span><span class="f-bold-6 text-primary text-center product_modal_prices"></span></h2>
                                            <span class="add-to-wishlist-btn wish_modal"><i class="ti-heart"></i>Add to Wishlist</span>
                                            <hr class="line-divider">
                                            <form method="post" id="get_modal_pricing">
                                                <input type="hidden" id="product_modal_id"/>
                                            <div class="select-measurement-sec">
                                                <div class="">
                                                    <input class="measure" type="radio" name="measure" id="mm-measure" value="mm">
                                                    <label class="form-check-label" for="mm-measure">
                                                        mm
                                                    </label>
                                                </div>
                                                <div class="text-center">
                                                    <input class="measure" type="radio" name="measure" id="cm-measure" value="cm">
                                                    <label class="form-check-label" for="cm-measure">
                                                        cm
                                                    </label>
                                                </div>
                                                <div class="text-right">
                                                    <input class="measure" type="radio" name="measure" id="inch-measure" value="inch" checked>
                                                    <label class="form-check-label" for="inch-measure">
                                                        inches
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="single-checkout-box">
                                                <div class="input-group-measurement-sec width-100 d-flex">
                                                    <span class="bg-primary"><i class="ti-arrows-vertical"></i></span>
                                                    <input type="hidden" class="height_measure">
                                                    <input type="text" placeholder="Enter Height" class="height_measure_modal" name="height_measure"  required >
                                                </div>
                                                <span class="text-danger height_measure_error"></span>
                                                <div class="input-group-measurement-sec width-100 d-flex">
                                                    <span class="bg-primary"><i class="ti-arrows-horizontal"></i></span>
                                                    <input type="hidden" class="width_measure">
                                                    <input type="text" placeholder="Enter Width" class="width_measure_modal" name="width_measure"  required >
                                                </div>
                                                <span class="text-danger width_measure_error" ></span>
                                            </div>
                                                <input id="total_price" name="total_price" class="total_price" type="hidden" value="">
                                                <h2 class="f-bold-6 text-primary text-center mt--10 mb--10">£<span class="get_quote_price"></span></h2>
                                                <span class="text-danger prices_measure_error" ></span>
                                            </form>
                                            <div class="d-flex width-100">
                                                <button class="btn-primary width-100" type="button" onclick="getPrice('modal')">Get Quotes</button>
                                            </div>

                                            <hr class="line-divider">
                                            <form method="post" id="add_cart_modal">
                                            <div class="cust-product-form product_page single-checkout-box select-option">
                                                <span class="text-primary"><i class="ti-info-alt"></i>Select Your fitting type</span>
                                                <div class="select-fitting-type-sec">
                                                    <div class="">
                                                        <input class="fitting" type="radio" name="fitting" value="recess" id="recess-fit">
                                                        <label class="form-check-label" for="recess-fit">
                                                            Recess
                                                        </label>
                                                    </div>
                                                    <div class="">
                                                        <input class="fitting" type="radio" name="fitting" value="exact" id="exact-fit" >
                                                        <label class="form-check-label" for="exact-fit">
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
                                            <div class="cust-product-form product_page single-checkout-box select-option exact_dropdown_modal" style="display: none;">
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
                                                <button class="btn-primary width-100" type="button" onclick="saveCart('modal')" id="save_cart">Add To Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Checkbox Area -->
                                </div><!-- .product-info -->
                            </div><!-- .modal-product -->
                        </div><!-- .modal-body -->
                    </div><!-- .modal-content -->
                </div><!-- .modal-dialog -->
            </div>
            <!-- END Modal -->
        </div>
        <!-- END QUICKVIEW PRODUCT -->
        <!-- Placed js at the end of the document so the pages load faster -->

        <!-- jquery latest version -->
        <script src="{{ asset('front/js/vendor/jquery-1.12.0.min.js') }}"></script>
        <!-- Bootstrap framework js -->
        <script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
        <!-- All js plugins included in this file. -->
        @yield('page_level_js')
        <!-- Waypoints.min.js. -->
        <script src="{{ asset('front/js/waypoints.min.js') }}"></script>
        <!-- Main js file that contents all jQuery plugins activation. -->
        <script src="{{ asset('front/js/main.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
        <script type="text/javascript">


            $(".cart__menu").click(function(){
                var slug = '{{ !empty($store->slug) ? $store->slug : "" }}';
                var form_data = new FormData();
                form_data.append('slug', slug);
                $.ajax({
                    type: "POST",
                    url: "{{route('user.storeCart')}}", // your php file name
                    data: form_data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data){
                        $('.shopping__cart').html('');
                        $('.shopping__cart').html(data.html);
                    },
                    error: function (errorString){
                        alert('contact to admin');
                    }
                });


            });
             $(document).on('click','.close_cart',function(){
                 $('.shopping__cart').removeClass('shopping__cart__on');
                 $('.body__overlay').removeClass('is-visible');
             })

             function removeproduct(id,dim)
             {
                 var slug = '{{ !empty($store->slug) ? $store->slug : "" }}';
                 var form_data = new FormData();
                 form_data.append('slug',slug);
                 form_data.append('id',id);
                 form_data.append('dim',dim);
                 $.ajax({
                     type: "POST",
                     url: "{{route('user.storeCart')}}", // your php file name
                     data: form_data,
                     dataType: "json",
                     processData: false,
                     contentType: false,
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     success: function (data){
                         $('.shopping__cart').html('');
                         $('.shopping__cart').html(data.html);
                         $('.total_cart').text('');
                         $('.total_cart').text(data.cart_count);

                     },
                     error: function (errorString){
                         alert('contact to admin');
                     }
                 });
             }


        function showSingleProduct(productID,view,wish='')
        {
            $.ajax({
                type: "POST",
                url: "{{route('store.produt.show')}}"+'/'+productID, // your php file name
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data){
                    if(data.status == 'success') {
                        $('.wish_modal').show();
                        if(wish=='wish'){
                            $('.wish_modal').hide();

                        }
                        $('#productModal').modal('show');

                        $('#product_modal_id').val(productID);
                        $('#get_modal_pricing').find("input[name='width_measure']").attr("placeholder", "min "+data.produc_detail.min_order_width);
                        $('#get_modal_pricing').find("input[class='width_measure']").val(data.produc_detail.min_order_width);
                        $('#get_modal_pricing').find("input[name='height_measure']").attr("placeholder", "min "+data.produc_detail.min_order_length);
                        $('#get_modal_pricing').find("input[class='height_measure']").val(data.produc_detail.min_order_length);
                        $('.product_modal_title').text('');
                        $('.product_modal_title').text(data.produc_detail.name);
                        $('.product_modal_prices').text('');
                        $('.product_modal_prices').html(" £ "+data.total_price);
                        $('.main-image').html('');
                        $('.main-image').html('<img src="'+data.main_image+'" style="width:100%"/>');

                    } else {

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
                        toastr.warning(data.message);

                    }

                },
                error: function (errorString){
                    alert('contact to admin');
                }
            });

        }

            $('.measure').change(function(){


                var min_height=$('.height_measure').val();
                var min_width=$('.width_measure').val();
                var measure= $('#get_modal_pricing').find('input[name="measure"]:checked').val();
                $('#get_modal_pricing').find("input[name='width_measure']").val('');
                $('#get_modal_pricing').find("input[name='height_measure']").val('');
                $('#get_modal_pricing').find("input[class='get_quote_price']").text('');
                $('#get_modal_pricing').find("input[class='total_price']").text('');

                if(measure=='inch')
                {
                    $('#get_modal_pricing').find("input[name='width_measure']").attr("placeholder", " ");
                    $('#get_modal_pricing').find("input[name='height_measure']").attr("placeholder", " ");
                    $('#get_modal_pricing').find("input[name='width_measure']").attr("placeholder", "min "+min_width);
                    $('#get_modal_pricing').find("input[name='height_measure']").attr("placeholder", "min "+min_height);

                }
                else if(measure=='cm'){
                    $('#get_modal_pricing').find("input[name='width_measure']").attr("placeholder", " ");
                    $('#get_modal_pricing').find("input[name='height_measure']").attr("placeholder", " ");
                    var cmwidth=min_width * 2.54;
                    var cmheight=min_height * 2.54;
                    cmwidth=cmwidth.toFixed(2);
                    cmheight=cmheight.toFixed(2);
                    $('#get_modal_pricing').find("input[name='width_measure']").attr("placeholder", "min "+cmwidth);
                    $('#get_modal_pricing').find("input[name='height_measure']").attr("placeholder", "min "+cmheight);


                }
                else{
                    $('#get_modal_pricing').find("input[name='width_measure']").attr("placeholder", " ");
                    $('#get_modal_pricing').find("input[name='height_measure']").attr("placeholder", " ");

                    var mmwidth=min_width * 25.4;
                    var mmheight=min_height * 25.4;
                    mmwidth=mmwidth.toFixed(2);
                    mmheight=mmheight.toFixed(2);
                    $('#get_modal_pricing').find("input[name='width_measure']").attr("placeholder", "min "+mmwidth);
                    $('#get_modal_pricing').find("input[name='height_measure']").attr("placeholder", "min "+mmheight);

                }

            });

            function getPrice(from=''){
                if(from=='modal'){

                    if($('#get_modal_pricing').find("input[name='height_measure']").val()==''){
                        $('.height_measure_error').html('please do not leave the height input field');
                        return false;
                    }

                    if($('#get_modal_pricing').find("input[name='width_measure']").val()==''){
                        if(from=='modal'){
                            $('.width_measure_error').html("please do not leave the width input field");
                            return false;
                        }

                    }

                }
                else{

                    if($('#width_measure').val()==''){

                            $('#width_measure_error').html('please do not leave the width input field');
                            return false;


                    }
                    if($('#height_measure').val()==''){
                        $('#height_measure_error').html('please do not leave the height input field');
                        return false;
                    }
                }
                var pageproductID="{{isset($singleProduct->id) && !empty($singleProduct->id) ? $singleProduct->id : ''}}";
                if(from=='modal'){
                    var productID=$('#product_modal_id').val();
                    var form = $('#get_modal_pricing')[0];
                    var form_data = new FormData(form);
                    var surl="{{route('store.produt.quote')}}"+'/'+productID; // your php file name
                }else if(pageproductID > 0 && pageproductID!=''){
                    var form = $('#get_pricing')[0];
                    var form_data = new FormData(form);
                    var surl="{{route('store.produt.quote')}}"+'/'+pageproductID; // your php file name
                }


                $.ajax({
                    type: "POST",
                    url: surl, // your php file name
                    data: form_data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data){
                        if(data.status == 'success') {
                            $('#width_measure_error').html('');
                            $('.width_measure_error').html('');
                            $('#height_measure_error').html('');
                            $('.height_measure_error').html('');
                            if(from=='modal'){
                                $('.get_quote_price').text('');
                                $('.get_quote_price').text(data.price);
                                $('.total_price').val('');
                                $('.total_price').val(data.price);
                            }else{


                                $('#get_quote_price').text('');
                                $('#get_quote_price').text(data.price);
                                $('#total_price').val('');
                                $('#total_price').val(data.price);

                            }


                        } else {
                            if(from=='modal'){
                                $('.width_measure').val('');
                                $('.height_measure').val('');
                                $('.get_quote_price').text('');
                                $('.get_quote_price').text(data.message);
                                $('.total_price').val('');
                            }else{
                                $('#width_measure').val('');
                                $('#height_measure').val('');
                                $('#get_quote_price').text('');
                                $('#get_quote_price').text(data.message);
                                $('#total_price').val('');
                            }

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
                            toastr.warning(data.message);

                        }
                    },
                    error: function (errorString){
                        alert('contact to admin');
                    }
                });

            }

            function saveCart(from=''){


                if(from=='modal'){

                    if($('#get_modal_pricing').find("input[name='height_measure']").val()==''){
                        $('.height_measure_error').html('please do not leave the height input field');
                        return false;
                    }

                    if($('#get_modal_pricing').find("input[name='width_measure']").val()==''){
                        $('.width_measure_error').html("please do not leave the width input field");
                            return false;


                    }
                    if($('.total_price').val() == ''){
                        $('.prices_measure_error').html("please do not leave the height && width input field empty");
                        return false;

                    }

                }
                else{

                    if($('#width_measure').val()==''){
                        $('#width_measure_error').html('please do not leave the width input field');
                        return false;
                    }
                    if($('#height_measure').val()==''){
                        $('#height_measure_error').html('please do not leave the height input field');
                        return false;
                    }
                    if($('#total_price').val() == ''){
                        $('.prices_error').html("please do not leave the height && width input field empty");
                        return false;

                    }
                }




                var pageproductID="{{isset($singleProduct->id) && !empty($singleProduct->id) ? $singleProduct->id : ''}}";
                if(from=='modal'){
                    var productID=$('#product_modal_id').val();
                    var form = $('#add_cart_modal')[0];
                    var form_data = new FormData(form);
                    var measure= $('#get_modal_pricing').find('input[name="measure"]:checked').val();
                    form_data.append('scale',measure);
                    form_data.append('height_measure',$('.height_measure_modal').val());
                    form_data.append('width_measure',$('.width_measure_modal').val());
                    form_data.append('total_price',$('.total_price').val());
                    var surl="{{route('user.addToCart')}}"+'/'+productID;

                }else if(pageproductID > 0 && pageproductID!=''){
                    var measure= $('#get_pricing').find('input[name="measure"]:checked').val();
                    var form = $('#add_cart')[0];
                    var form_data = new FormData(form);
                    form_data.append('scale',measure);
                    form_data.append('width_measure',$('#width_measure').val());
                    form_data.append('height_measure',$('#height_measure').val());

                    form_data.append('total_price',$('#total_price').val());
                    form_data.append('total_price',$('#total_price').val());
                    var surl="{{route('user.addToCart')}}"+'/'+pageproductID;
                }

                $.ajax({
                    type: "POST",
                    url: surl, // your php file name
                    data: form_data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data){
                        if(data.status == 'success') {
                            if(from=='modal'){
                                $('#productModal').modal('hide');
                            }

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
                            toastr.success(data.message);
                            $('.total_cart').text('');
                            $('.total_cart').text(data.quantity);
                            $('#get_pricing input[type="text"]').val('');
                            $('#get_pricing input[type="radio"]').val('');
                            $("#get_quote_price").html('')



                        } else {
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
                            toastr.warning(data.message);

                        }
                    },
                    error: function (errorString){
                        alert('contact to admin');
                    }
                });

            }

            $("input[class='fitting']").change(function(){
                var fitting=$('input[class="fitting"]:checked').val();

                if(fitting=='exact')
                {
                    $('.exact_dropdown_modal').show();
                }
                else{
                    $('.exact_dropdown_modal').hide();
                }

            });

            function resetForm(){
                document.getElementById("get_modal_pricing").reset();
                document.getElementById("add_cart_modal").reset();
            }

            function addWhishList(productID,wishID){
               @if(Auth::check())
                {
                    var lfckv = document.getElementById("productck_"+productID).checked;
                    var store_id = '{{ !empty($store->id) ? $store->id : "" }}';
                    var form_data = new FormData();
                    form_data.append('store_id',store_id);
                    form_data.append('product_id',productID);
                    form_data.append('id',wishID);
                    form_data.append('value',lfckv);

                    $.ajax({
                        type: "POST",
                        url: "{{route('addWhishList')}}", // your php file name
                        data: form_data,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data){
                            if(data.status == 'success') {
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
                                toastr.success(data.message);
                            } else {
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
                                toastr.warning(data.message);

                            }

                        },
                        error: function (errorString){
                            alert('contact to admin');
                        }
                    });

                }
                @else
                {
                    toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-bottom-right",
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
                    toastr.warning('you are not login ');


                }
                @endif


            }

            $( document ).ready(function() {
               var order_id="{{request()->response_id}}";
               var payment_status="{{request()->shouldShowBackButton}}";
               if(payment_status=='false'){

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
                       toastr.warning('something wrong your order payment not paid');

               }else{
                   if(order_id!=''){

                       var form_data = new FormData();
                       form_data.append('order_id',order_id);


                       $.ajax({
                           type: "POST",
                           url: "{{route('verifyPayment')}}", // your php file name
                           data: form_data,
                           dataType: "json",
                           processData: false,
                           contentType: false,
                           headers: {
                               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                           },
                           success: function (data){
                               if(data.status == 'success') {
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
                                   toastr.success(data.message);
                               }

                           },
                           error: function (errorString){
                               alert('contact to admin');
                           }
                       });


                   }
               }

            });




        </script>


    </body>
</html>

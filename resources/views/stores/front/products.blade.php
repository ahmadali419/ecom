@extends('layouts.template')

@section('title', 'Home')
@section('description', 'Home Description')

@section('page_level_css')
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

    </style>
@endsection

@section('content')
    <div class="ht__bradcaump__area"
        style="background: rgba(0, 0, 0, 0)
        url({{asset(isset($storeSetting->products_cover_image) && !empty($storeSetting->products_cover_image) ? $storeSettingImg=$storeSetting->products_cover_image : $storeSettinID='front/images/slider/bg/bradcaump-bg-1920x320.jpg')}}) no-repeat scroll
        center center / cover ;">
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
                                                    @if (!$storeProductCategory->isEmpty())
                                                        @foreach ($storeProductCategory as $storeCatObj)
                                                            <li><input type="checkbox" /><a class="ml-3 link-secondary"
                                                                    data-filter=".cat--1"
                                                                    href="#default">{{ ucfirst($storeCatObj->name) }}</a>
                                                            </li>
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
                                                    @if (!$storeProductColor->isEmpty())
                                                        @foreach ($storeProductColor as $storeColorObj)
                                                            <li class="black"><input type="checkbox" /><a
                                                                    class="ml-3 link-secondary" href="#">Black</a></li>
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
                                    <button data-filter="*" class="width-100 text-left pl-0 store_categories">All</button>
                                    @if (!$storeProductCategory->isEmpty())
                                        @foreach ($storeProductCategory as $catObj)
                                            <button
                                                class="link-dark width-100 text-left pl-0 store_categories  {{ $catObj->id == last(request()->segments()) ? 'is-checked' : '' }}"
                                                data-id="{{ $catObj->id }}"
                                                data-filter=".cat--1">{{ $catObj->name }}</button>
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
                                <label><span>You range</span> <input class="padding-1 border-0" type="text" id=""
                                        readonly=""><span id="max-min-prices">${{!empty( $filterPrices['MinPrice']) ?  $filterPrices['MinPrice'] :'' }} -
                                        ${{ !empty($filterPrices['MaxPrice']) ? $filterPrices['MaxPrice'] : '' }}</span></label>
                                <div class="range-slider clearfix">
                                    <div class="row">

                                        <div class="col-md-12" style="padding-top:12px">
                                            <div id="price_range"></div>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="hidden" name="maximum_range" id="maximum_price"
                                                class="form-control"
                                                value="{{ !empty($filterPrices['MaxPrice']) ? $filterPrices['MaxPrice'] : '' }}" />
                                            <input type="hidden" name="minimum_range" id="minimum_price"
                                                class="form-control"
                                                value="{{ !empty($filterPrices['MinPrice']) ? $filterPrices['MaxPrice'] : '' }}" />
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="range-slider clearfix"> --}}
                                {{-- <form action="#" method="get">

                                        <label><span>You range</span> <input class="padding-1 border-0" type="text" id="" readonly=""><span id="max-min-prices">${{$filterPrices->Minprice}} - ${{$filterPrices->Maxprice}}</span></label>
                                        <div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all"><div class="ui-slider-range ui-widget-header ui-corner-all" style="left: 0%; width: 67.5%;"></div><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 0%;"></span><span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0" style="left: 67.5%;"></span></div>
                                    </form> --}}
                                {{-- </div> --}}
                            </div>



                            <div class="cust_cart_box s-side-text mt--40">
                                <div class="sidebar-title clearfix">
                                    <h3 class="floatleft h7-heading text-secondary">Color</h3>
                                </div>
                                <div class="single__filter">
                                    <ul class="filter__list sidebar__list">
                                        @if (!$storeProductColor->isEmpty())
                                            @foreach ($storeProductColor as $storeColorObj)
                                                <li class="black"><input type="checkbox" class="product-colors"
                                                        {{ $storeColorObj->id == last(request()->segments()) ? 'checked' : '' }}
                                                        name="colors[]" value="{{ $storeColorObj->id }}" /><a
                                                        class="link-secondary ml-3"
                                                        href="#">{{ ucfirst($storeColorObj->name) }}</a></li>
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
                                        {{--  <ul>
                                            <li class="text-right">
                                                <div class="filter__box">
                                                    <a class="filter__menu link-primary" href="#">filter</a>
                                                </div>
                                            </li>
                                        </ul>  --}}
                                    </div>
                                </div>
                            </div>


                            <!-- End Product MEnu -->
                            <input type="hidden" name="all_count" id="all_count"
                                value="{{ !empty($products) ? $products->count() : '' }}">
                            <div class="row product__list">

                                    <!-- Start Single Product -->
                                    @if (!$products->isEmpty())
                                        @foreach ($products as $productObj)
                                           <div class="col-md-4  col-lg-4 col-sm-6 col-xs-12 cat--3">
                                                <div class="product foo">
                                                    <div class="product__inner">
                                                        <div class="pro__thumb">
                                                            <a href="{{ route('store.product.detail', [$productObj->slug, $productObj->id]) }}">
                                                                <img src="{{ asset('product/coverimage') . '/' . $productObj->main_image }}"
                                                                    alt="product images">
                                                            </a>
                                                        </div>
                                                        <div class="product__hover__info">
                                                            <ul class="product__action border-normal bg-primary">
                                                                <li><a onclick="showSingleProduct({{$productObj->id}},'modal')"
                                                                       title="Quick View"
                                                                        class="quick-view modal-view detail-link"
                                                                        ><span class="ti-plus"></span></a>
                                                                </li>
                                                                <li><a title="Add TO Cart" href="{{route('user.viewCart',[$store->slug])}}"><span
                                                                            class="ti-shopping-cart"></span></a></li>
                                                                <li>

                                                                <input type='checkbox' id="productck_{{$productObj->id}}"  @if(!empty($productObj->wishID)) checked @endif onclick="addWhishList({{$productObj->id}},{{isset($productObj->wishID) && $productObj->wishID > 0 ? $productObj->wishID :'-1'}})"/><label for="productck_{{$productObj->id}}"></label>

                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="product__details">
                                                        <h2><a class="link-secondary"
                                                                href="{{ route('store.product.detail', [$productObj->id]) }}">{{ $productObj->name }}</a>
                                                        </h2>
                                                        <ul class="product__price">
                                                            {{-- <li class="old__price">£16.00</li> --}}
                                                            <li class="new__price text-primary pl-0">£{{$productObj->sale_price }}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                            </div>
                              <div class="row">
                                  <div class="col-12">
                                    <div class="ajax-load text-center" style="display:none">
                                        <p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
                                    </div>
                                  </div>
                              </div>
                            <!-- Start Load More BTn -->
                            {{-- <div class="row mt--60">
                                <div class="col-md-12">
                                    <div class="htc__loadmore__btn">
                                        <a class="btn-primary" href="#">load more</a>
                                    </div>
                                </div>
                            </div> --}}

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
    <script>
        $(document).on('click', '.store_categories', function() {
            var catId = $(this).attr('data-id');

             page =1;
            var form_data = new FormData();
            var colorIds = $('input[name="colors[]"]:checked').serialize();

            var slug = "{{ $store->slug }}";
            formData = form_data.append('catId', (catId) ? catId : '');
            formData = form_data.append('colorIds', (colorIds) ? colorIds : '');
            formData = form_data.append('slug', slug)
            $.ajax({
                type: "POST",
                url: "{{ route('getProductByCat') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        // console.log(data.filterPrices.Minprice);
                        console.log(data.totalProducts);
                        $('#all_count').val(data.totalProducts);
                        $('.product__list').html('');
                        $('.product__list').html(data.html);
                        if (data.filterPrices.Minprice != null && data.filterPrices.Maxprice != null) {
                            $('#max-min-prices').html('');
                            $('#max-min-prices').html('$' + data.filterPrices.Minprice + ' ' + '-' +
                                ' ' + '$' + data.filterPrices.Maxprice);
                            $("#maximum_price").val('');
                            $("#maximum_price").val(data.filterPrices.Maxprice);
                            $("#minimum_price").val('');
                            $("#minimum_price").val(data.filterPrices.Minprice);
                        }
                        // $('.product__list').show('slo');

                    } else {
                        $('.product__list').html('');
                        // $('.product__list').html('<p>Sorry no product found!</p>');
                    }
                },
                error: function(errorString) {
                    // Swal.fire("Sorry!", "Something went wrong please contact to admin",
                    //     "error");
                }
            });
        });

        $(document).on('change', '.product-colors', function() {
            var colorIds = $('input[name="colors[]"]:checked').serialize();
            var form_data = new FormData();
            var catId = $('.is-checked').attr('data-id');
            var slug = "{{ $store->slug }}";
            form_data.append('colorIds', colorIds);
            form_data.append('catId', catId);
            form_data.append('slug', slug);
            $.ajax({
                type: "POST",
                url: "{{ route('getProductByCat') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('.product__list').html('');
                        $('.product__list').html(data.html);
                        if (data.filterPrices.Minprice != null && data.filterPrices.Maxprice != null) {
                            $('#max-min-prices').html('');
                            $('#max-min-prices').html('$' + data.filterPrices.Minprice + ' ' + '-' +
                                ' ' + '$' + data.filterPrices.Minprice);
                            $("#maximum_price").val('');
                            $("#maximum_price").val(data.filterPrices.Maxprice);
                            $("#minimum_price").val('');
                            $("#minimum_price").val(data.filterPrices.Minprice);

                        }
                        // $('.product__list').show('slo');

                    } else {
                        $('.product__list').html('');
                        $('.product__list').html('<p>Sorry no product found!</p>');
                    }
                },
                error: function(errorString) {
                    // Swal.fire("Sorry!", "Something went wrong please contact to admin",
                    //     "error");
                }
            });

        });
        var allcount = $('#all_count').val();

        function loadMoreData(page, new_page = '') {

            var category_id = $('.is-checked').attr('data-id');

            var slug = "{{ $store->slug }}";
            var allcount = $('#all_count').val();
            // alert(allcount);return;
            // var search_course = $('#search_course').val();
            if (allcount > 0) {
                $.ajax({

                        data: {
                            category_id: category_id,
                            slug,
                            slug
                        },
                        url: "{{ route('storeProductPagniate') }}"+ "/?page=" + page,
                        type: 'get',
                        beforeSend: function() {
                            $(".ajax-load").show();
                        }
                    })
                    .done(function(data) {
                        if (data.html == "" && new_page == 'new_page') {
                            $(".product__list").empty();
                        }
                        if (data.html == "") {
                            // $("#all_count").val('');
                            $("#all_count").val(0);
                            $(".ajax-load").show();
                            $('.ajax-load').html("No more products Found!");
                            return;
                        }
                        $('.ajax-load').hide();
                        if (new_page == 'new_page') {
                            $("#all_count").val('');
                            $("#all_count").val(data.totalProducts);
                            $(".product__list").empty();
                            $(".product__list").append(data.html);
                        } else {
                            $(".product__list").append(data.html);
                        }

                    })
                    // Call back function
                    .fail(function(jqXHR, ajaxOptions, thrownError) {
                        alert("Server not responding.....");
                    });
            }

        }


        var page = 1;
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() + 100 >= $(document).height()) {
                if (allcount > 0) {
                page++;
                loadMoreData(page);
                }
            }

        });
        $(document).ready(function() {


            var min = $("#minimum_price").val();
            var max = $("#maximum_price").val();
            var minPrice = "{{ !empty($filterPrices['MinPrice']) && $filterPrices['MinPrice'] >= 0 ? $filterPrices['MinPrice'] : 0}}";
            var maxPrice = "{{ !empty($filterPrices['MaxPrice']) && $filterPrices['MaxPrice'] >= 0 ? $filterPrices['MaxPrice'] : 0}}";
            // var maxPrice = <?php !empty($filterPrices->Maxprice) && $filterPrices->Maxprice >= 0 ? $filterPrices->Maxprice : 0?>;
            $("#price_range").slider({
                range: true,
                min: Math.trunc(minPrice),
                max: Math.trunc(maxPrice),
                values: [{{ !empty($filterPrices['MinPrice']) && $filterPrices['MinPrice'] >= 0 ? $filterPrices['MinPrice'] : 0}}, {{ !empty($filterPrices['MaxPrice']) && $filterPrices['MaxPrice'] >= 0 ? $filterPrices['MaxPrice'] : 0}}],
                slide: function(event, ui) {
                    // alert('yes');
                    $("#minimum_price").val(ui.values[0]);
                    $("#maximum_price").val(ui.values[1]);
                    load_product(ui.values[0], ui.values[1])
                }
            });


            function load_product(minimum_range, maximum_range) {
                // console.log(maximum_range);return;
                var colorIds = $('input[name="colors[]"]:checked').serialize();
            var form_data = new FormData();
            var catId = $('.is-checked').attr('data-id');
            var slug = "{{ $store->slug }}";
            form_data.append('colorIds', colorIds);
            form_data.append('catId', catId);
            form_data.append('slug', slug);
            form_data.append('minimum_range', minimum_range);
            form_data.append('maximum_range', maximum_range);
            $.ajax({
                type: "POST",
                url: "{{ route('getProductByCat') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.status == 'success') {
                        $('.product__list').html('');
                        $('.product__list').html(data.html);
                        // if (data.filterPrices.Minprice != null && data.filterPrices.Maxprice != null) {
                        //     $('#max-min-prices').html('');
                        //     $('#max-min-prices').html('$' + data.filterPrices.Minprice + ' ' + '-' +
                        //         ' ' + '$' + data.filterPrices.Minprice);
                        //     $("#maximum_price").val('');
                        //     $("#maximum_price").val(data.filterPrices.Maxprice);
                        //     $("#minimum_price").val('');
                        //     $("#minimum_price").val(data.filterPrices.Minprice);

                        // }
                        // $('.product__list').show('slo');

                    } else {
                        $('.product__list').html('');
                        $('.product__list').html('<p>Sorry no product found!</p>');
                    }
                },
                error: function(errorString) {
                    // Swal.fire("Sorry!", "Something went wrong please contact to admin",
                    //     "error");
                }
            });
                // $.ajax({
                // 	url:"fetch.php",
                // 	method:"POST",
                // 	data:{minimum_range:minimum_range, maximum_range:maximum_range},
                // 	success:function(data)
                // 	{
                // 		$('#load_product').fadeIn('slow').html(data);
                // 	}
                // });
            }
        });
    </script>
@endsection

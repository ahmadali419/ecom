@extends('layouts.template')

@section('title', 'Home')
@section('description', 'Home Description')

@section('page_level_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<style>
    .quantity{
        width: 71%;
    }
    .position{
        display: flex;
        justify-content: center;
        margin-bottom: 3px;
    }
    .hide{
        display: none;
    }
</style>
@endsection

@section('content')
<!-- Start Bradcaump area -->
<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0)
                url({{asset(isset($storeSetting->cart_image) && !empty($storeSetting->cart_image) ? $storeSettingImg=$storeSetting->cart_image : $storeSettinID='front/images/slider/bg/bradcaump-bg-1920x320.jpg')}}) no-repeat scroll
                center center / cover ;">
    <div class="ht__bradcaump__wrap">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Cart</h2>
                        <nav class="bradcaump-inner">
                            <a class="breadcrumb-item link-primary" href="index.html">Home</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb-item active">Cart</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- cart-main-area start -->
<div class="cart-main-area ptb--50 bg__white">
    <div class="container">

        <!-- <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12"> -->
        <form action="#">
            <div class="row">
                <div class="col-md-8 col-sm-12 col-xs-12">
                     @php
                              $cart= session()->get($storeSetting->slug);

                                $subtotal=0;
                                @endphp
                                @if(!empty($cart) && count($cart) > 0)
                                    @foreach($cart as $productId => $arr)
                                        @php
                                            $k = array_key_first($arr);

                                        @endphp
                        @if(!empty($k))
                    <div class="col-md-12 col-sm-12 col-xs-12 mt--60">
                        <div class="cust_cart_box shp__cart__wrap">
                            <div class="shp__single__product">
                                <div class="shp__pro__details">
                                    <div class="shp__pro__thumb col-lg-2 col-md-12 col-sm-12">
                                        <a href="#" class="">
                                            <img src="{{$arr[$k]['image']}}" alt="product images">
                                        </a>
                                    </div>
                                    @foreach($arr as $dim => $ca)
                                        @php
                                            $subtotal += $ca['price'];
                                        @endphp
                                    <div class="row col-lg-12">
                                        <div class="col-lg-3 col-md-2 col-sm-2 position">
                                            <h2><a href="product-details.html">{{ucfirst($ca['product_name'])}}</a></h2>
                                        </div>

                                        <div class="col-lg-1 col-md-2 col-sm-2 position"> {{ $dim }}</div>
                                        <div class="col-lg-4 col-md-5 col-sm-4 position">
                                            <div class="quantity buttons_added">
                                                <a onclick="quantityCartItem({{$productId}},'{{$dim}}')" value="+" class="qty-minus product_qty"><i class="fa fa-minus-circle text-primary" aria-hidden="true"></i></a>
                                                <input class="quantity" type="number" step="1" min="1" readonly max="" name="quantity"
                                                    id="qty_{{$productId}}_{{$dim}}" value="{{$ca['quantity']}}"
                                                    title="Qty" class="input-text qty text" size="4" pattern=""
                                                    inputmode="">
                                                <a onclick="quantityCartItem({{$productId}},'{{$dim}}')" value="+" class="qty-plus"><i class="fa fa-plus-circle text-primary" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-2 col-sm-2 position"> <span class="shp__price text-primary">£
                                                {{$ca['price']}}</span></div>
                                        <div class="col-lg-2 col-md-2 col-sm-2">
                                            <div class="position remove__btn">
                                                <a href="javascript:;" title="Remove this item"><button type="button" onclick="removeCartItem({{$productId}},'{{$dim}}')" class="btn btn-primary">Remove</button></a>
                                            </div>
                                        </div>
                                    </div>
                                        @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                      @endif
                    </div>
                    @endforeach
                            @endif
                <div class="col-md-4 col-sm-12 col-xs-12 mt--60">
                    <div class="cust_cart_box shp__cart__wrap right-card-total row">
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="coupon">
                                <h2>Coupon</h2>
                                <p>Enter your coupon code if you have one.</p>
                                <input type="text" placeholder="Coupon code" />
                                <input class="btn-primary width-50 text-center" value="Apply Coupon" />
                            </div>

                        </div>
                        @if($subtotal > 0)
                        <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                            <div class="cart_totals">
                                <h2>Cart Totals</h2>
                                <div class="row">
                                    <div class="col-xs-6 text-left">
                                        <span>Subtotal</span>
                                    </div>
                                    <div class="col-xs-6">
                                        <span>£{{$subtotal}}</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6 text-left">
                                        <strong><span class="">Total</span></strong>
                                    </div>
                                    <div class="col-xs-6">
                                        <strong><span class="amount">£{{$subtotal}}</span></strong>
                                    </div>
                                </div>
                                <div class="d-flex width-100 mt--10 text-center">
                                    <a class="btn-primary width-100" href="{{route('cart.checkout',[$store->slug])}}">Proceed to
                                        Checkout</a>
                                </div>
                            </div>

                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </form>
        <!-- </div>
        </div> -->

    </div>
</div>
<!-- cart-main-area end -->
<!-- End Our Product Area -->
@endsection
@section('page_level_js')

<script src="{{ asset('front/js/plugins.js') }}"></script>
<script src="{{ asset('front/js/slick.min.js') }}"></script>
<script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
<script type="text/javascript">
function removeCartItem(product_id, dim) {
    var slug = '{{ !empty($store->slug) ? $store->slug : "" }}';
    var form_data = new FormData();
    form_data.append('slug', slug);
    form_data.append('id', product_id);
    form_data.append('dim', dim);
    $.ajax({
        type: "POST",
        url: "{{route('user.removesCartItem')}}", // your php file name
        data: form_data,
        dataType: "json",
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            window.location.reload(false);
        },
        error: function(errorString) {
            alert('contact to admin');
        }
    });
}

$(document).on('click', '.qty-plus', function() {
    $(this).prev().val(+$(this).prev().val() + 1);
});
$(document).on('click', '.qty-minus', function() {
    if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
});

function quantityCartItem(product_id, dim) {
    setTimeout(function() {
        // alert(product_id);
        // alert(dim);
        var slug = '{{ !empty($store->slug) ? $store->slug : "" }}';
        //var qty=$('#qty_'+product_id+'_'+dim).val();
        let index = 0

        let result = dim.replace(/\./g, (item) => "\\.");

        var qty = $('#qty_' + product_id + '_' + result).val();
        var form_data = new FormData();
        form_data.append('slug', slug);
        form_data.append('id', product_id);
        form_data.append('dim', dim);

        form_data.append('qty', qty);
        $.ajax({
            type: "POST",
            url: "{{route('user.addCartQuantity')}}", // your php file name
            data: form_data,
            dataType: "json",
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                window.location.reload(false);
            },
            error: function(errorString) {
                alert('contact to admin');
            }
        });

    }, 500);

}
$( ".menu-extra" ).css( "display", "none" );
</script>
@endsection


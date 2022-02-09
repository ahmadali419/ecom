@extends('layouts.template')

@section('title', 'Whishlist')
@section('description', 'Whishlist Description')

@section('page_level_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <style>
        .shp__pro__details {
            min-width: 80% !important;
        }
    </style>

@endsection

@section('content')
    <!-- Start Bradcaump area -->

    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0)
        url({{asset('front/images/bg/blinds_banner-1024x429.jpg')}}) no-repeat scroll
        center center / cover ;">
        <div class="ht__bradcaump__wrap">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="bradcaump__inner text-center">
                            <h2 class="bradcaump-title">Wishlist</h2>
                            <nav class="bradcaump-inner">
                                <a class="breadcrumb-item" href="index.html">Home</a>
                                <span class="brd-separetor">/</span>
                                <span class="breadcrumb-item active">Wishlist</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- wishlist-area start -->
    <div class="wishlist-area ptb--120 bg__white">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="wishlist-content">
                        <form action="#">

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <div class="cust_cart_box shp__cart__wrap">
                                        @if(!$wishList->isEmpty())
                                            @foreach($wishList as $wish)
                                            <div class="shp__single__product">
                                            <div class="shp__pro__thumb">
                                                <a href="{{ route('store.product.detail', [$store->slug, $wish->product_id]) }}">
                                                    <img
                                                        src="{{ asset('product/coverimage') . '/' . $wish->main_image }}"
                                                        alt="product images">
                                                </a>
                                            </div>
                                            <div class="shp__pro__details">
                                                <h2><a class="link-secondary" href="{{ route('store.product.detail', [$store->slug, $wish->product_id]) }}">{{$wish->name}}</a></h2>
                                                <span class="shp__price text-primary">£ {{$wish->sale_price}}</span>

                                                <div class="wishlist-content">
                                                    <div class="wishlist-content-btn mt--10"><a class="btn-primary" onclick="showSingleProduct({{$wish->product_id}},'modal','wish')"> Order Now</a></div>
                                                </div>
                                            </div>
                                            <div class="remove__btn">
                                                <a onclick="removeWishProduct({{$wish->WishID}})" title="Remove this
                                                        item"><i class="zmdi
                                                            zmdi-close link-primary"></i></a>
                                            </div>
                                        </div>
                                            @endforeach
                                        @endif

                                    </div>

                                    {{--<div class="buttons-cart mt--30">
                                        <a class="btn-primary" href="#">Continue Shopping</a>
                                        <input class="btn-primary" type="submit" value="Update Wishlist"/>
                                    </div>--}}
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- wishlist-area end -->





@endsection
@section('page_level_js')

    <script src="{{ asset('front/js/plugins.js') }}"></script>
    <script src="{{ asset('front/js/slick.min.js') }}"></script>
    <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('front/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
    <script type="text/javascript">
        function removeWishProduct(wishID){
            var form_data = new FormData();
            form_data.append('wishID', wishID);
            Swal.fire({
                title: "Are you sure?",
                text: "You wont be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{route('removeWishList')}}", // your php file name
                        data: form_data,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data){
                            if(data.status == 'success') {
                                Swal.fire("Success!", data.message, "success");
                                window.setTimeout(function(){
                                   location.reload();
                                },3000)

                            } else {
                                Swal.fire("Sorry!", data.message, "error");
                            }
                        },
                        error: function (errorString){
                            Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                        }
                    });
                }
            });





        }
    </script>
@endsection


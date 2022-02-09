@extends('layouts.template')

@section('title', 'Checkout')
@section('description', 'Checkout')

@section('page_level_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        .iti.iti--allow-dropdown.iti--separate-dial-code,.iti{
            width: 100%!important;
        }
        .iti--allow-dropdown input, .iti--allow-dropdown input[type=text], .iti--allow-dropdown input[type=tel], .iti--separate-dial-code input, .iti--separate-dial-code input[type=text], .iti--separate-dial-code input[type=tel] {
            padding-left: 85px!important;
        }
        .error {
            color: red !important;
        }
        .iti__flag-container{
            padding: 12px;
        }

        .iti__selected-flag {
            padding: 12px;

        }
        .table>tbody>tr>td{
            padding: 3px !important;
            vertical-align: baseline;
        }
        .table{
            margin-bottom: 0px !important;
        }
        .w-35{
            width: 35%;
        }
    </style>
@endsection

@section('content')
    @php
        $cart = session()->get($storeSetting->slug);

        $subtotal = 0;
        if (count($cart) > 0){

           foreach ($cart as $productId => $arr){
               $k = array_key_first($arr);

               if (!empty($k)){
                  foreach ($arr as $dim => $ca){
                      $subtotal += $ca['price'];
                  }
               }
           }

        }

    @endphp

    @php $cart = session()->get($store->slug) @endphp
    @if (!empty($cart))
        <div class="ht__bradcaump__area"
             style="background: rgba(0, 0, 0, 0) url(../../front/images/bg/blinds_banner-1024x429.jpg) no-repeat scroll center center / cover ;">
            <div class="vfht__bradcaump__wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="bradcaump__inner text-center">
                                <h2 class="bradcaump-title">Checkout</h2>
                                <nav class="bradcaump-inner">
                                    <a class="breadcrumb-item link-primary" href="index.html">Home</a>
                                    <span class="brd-separetor">/</span>
                                    <span class="breadcrumb-item active">Checkout</span>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cart-main-area ptb--50 bg__white">
            <div class="container">
                <section class="our-checkout-area ptb--90 bg__white">
                    <div class="container">
                        <div class="row">
                            <form id="confirmOrderForm" method="POST" action="{{route('confirmOrder')}}">
                                @csrf
                                <input type="hidden" value="{{$subtotal}}" name="totle_paid_amount">
                                <input type="hidden" value="{{$store->slug}}" name="slug">
                                <input type="hidden" value="{{$store->id}}" name="store_id">
                                <input type="hidden" value="" id="country_short_code" name="country_short_code">
                                <input type="hidden" value="" id="selectedcontryname" name="selectedcontryname">
                                <div class="col-md-8 col-lg-8">
                                    <div class="cust_cart_box ckeckout-page ckeckout-left-sidebar mb--30">
                                        <!-- Start Checkbox Area -->
                                        <div class="checkout-form">
                                            <h2 class="title__line text-primary">Billing Details</h2>
                                            <div class="row">
                                                <div class="col-12">
                                                    <span class="text-danger main_error"></span>
                                                </div>
                                            </div>
                                            <div class="checkout-form-inner">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if(!empty(Auth::user()->name))
                                                            @php
                                                                $name = explode(" ", Auth::user()->name);
                                                                $firstname = $name[0];
                                                                $lastname = isset($name[1]) && !empty($name[1]) ? $name[1] : '';
                                                            @endphp

                                                        @endif
                                                        <input class="pt--10 pb--10 pr-2 pl-2 mb--10 width-100" value="{{!empty(($firstname)) ? $firstname : ''}}" name="first_name" required placeholder="First Name*">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="pt--10 pb--10 pr-2 pl-2 mb--10 width-100"value="{{!empty(($lastname)) ? $lastname : ''}}" name="last_name" required placeholder="Last Name*">
                                                    </div>
                                                </div>
                                                @if(!(Auth::check()))
                                                    <div class="mb-4" style="margin-bottom: 14px;"><span><input type="checkbox" name="create_account" > Create account?</span></div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input class="pt--10 pb--10 pr-2 pl-2 mb--10" type="email" value="{{(Auth::check()) ? Auth::user()->email : ''}}" required name="email" required placeholder="Email*" {{(Auth::check()) ? "readonly" : ''}}>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="pt--10 pb--10 pr-2 mb--10 width-100" type="text" onchange="getcountrycode(this);" value="{{(Auth::check()) ? Auth::user()->phone_number : ''}}" id="phone_number" name="phone" required placeholder="Phone*">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <textarea class="pt--10 pb--10 pr-2 pl-2 mb--10 bg-white" value="{{(Auth::user()) ? Auth::user()->address : ''}}" placeholder="Address" required name="address">{{(Auth::user()) ? Auth::user()->address : ''}}</textarea>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select name="country" id="countryId" class="countries pt--10 pb--10 pr-2 pl-2 mb--10">
                                                            <option value="">Select Country*</option>
                                                            @if(!empty(Auth::user()->country))
                                                                <option selected value="{{ !empty(Auth::user()->country) ? Auth::user()->country : '' }}">{{Auth::user()->country}}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select name="state" class="states pt--10 pb--10 pr-2 pl-2 mb--10" id="stateId">
                                                            <option value="">Select State</option>
                                                            @if(!empty(Auth::user()->state))
                                                                <option selected value="{{ !empty(Auth::user()->state) ? Auth::user()->state : '' }}">{{Auth::user()->state}}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select name="city" class="cities pt--10 pb--10 pr-2 pl-2 mb--10"  id="cityId">
                                                            <option value="">Select City</option>
                                                            @if(!empty(Auth::user()->city))
                                                                <option selected value="{{ !empty(Auth::user()->city) ? Auth::user()->city : '' }}">{{Auth::user()->city}}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="pt--10 pb--10 pr-2 pl-2 mb--10" type="text" value="{{(Auth::check()) ? Auth::user()->zip_code : ''}}" name="zip_code" required placeholder="Zip Code*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Checkbox Area -->


                                        <!-- Start Payment Box -->
                                       {{-- <div class="payment-form">
                                            <div class="row">
                                                <div class="col-lg-9">
                                                    <h2 class="title__line text-primary">Payment Details</h2>
                                                    --}}{{-- <p>Lorem ipsum dolor sit amet, consectetur kgjhyt</p> --}}{{--
                                                </div>
                                                <div class="col-lg-3">
                                                    --}}{{-- <div class="buttons-cart">
                                                            <input class="btn-primary" type="submit" value="Copy Address" />
                                                        </div> --}}{{--
                                                </div>
                                            </div>
                                            <div class="checkout-form-inner">

                                                <!-- New Form Code : Start  -->

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input class="owner_name pt--10 pb--10 pr-2 pl-2 mb--10" type="text" name="user_card_name" required placeholder="Card owner name">
                                                    </div>
                                                    <div class="col-md-6">

                                                        <input class="card_no pt--10 pb--10 pr-2 pl-2 mb--10 width-100" type="number" name="user_card_no" required placeholder="Card number">

                                                        <!-- <input class="pt--10 pb--10 pr-2 pl-2 mb--10 width-100" name="user_card_no" type="number" required placeholder="Card number"> -->

                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input class="exp_month pt--10 pb--10 pr-2 pl-2 mb--10 width-100" type="month" required name="exp_month" placeholder="Expiry Month">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="exp_year pt--10 pb--10 pr-2 pl-2 mb--10 width-100" type="year" name="exp_year" required placeholder="Expiry Year">
                                                    </div>
                                                </div>
                                                <!-- New Form Code : End  -->
                                            </div>
                                        </div>--}}
                                        <!-- End Payment Box -->
                                        <div class="buttons-cart mtb--0">
                                            <a class="btn-primary" href="{{ url('') }}{{ '/store/'}}"
                                               class="return">Return to shop</a>
                                            <button class="btn-primary order_btn" type="submit">Next</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-4 col-lg-4">
                                <div class="cust_cart_box checkout-right-sidebar mb--30">
                                    <div class="our-important-note">
                                        <div class="coupon userpayment-page-coupon">
                                            <h2>Coupon</h2>
                                            <p>Enter your coupon code if you have one.</p>
                                            <input type="text" placeholder="Coupon code" />
                                            <input class="btn-primary width-50 text-center" value="Apply Coupon" />
                                        </div>
                                    </div>
                                </div>
                                <div class="cust_cart_box checkout-right-sidebar">
                                    <div class="our-important-note">
                                        <h2 class="title__line text-primary">Summary</h2>

                                        <div class="shp__cart__wrap">
                                            @php
                                                $cart = session()->get($storeSetting->slug);
                                                $subtotal = 0;
                                            @endphp
                                            @if (count($cart) > 0)
                                                @foreach ($cart as $productId => $arr)
                                                    @php
                                                        $k = array_key_first($arr);
                                                    @endphp
                                                    @if (!empty($k))
                                                        <div class="shp__single__product mt--40">
                                                            <div class="shp__pro__thumb">
                                                                <a href="#">
                                                                    <img src="{{ $arr[$k]['image'] }}" alt="product images">
                                                                </a>
                                                            </div>
                                                            <table class="table table-borderless">
                                                                @foreach ($arr as $dim => $ca)
                                                                    @php
                                                                        $subtotal += $ca['price'];
                                                                    @endphp
                                                                    <tr>
                                                                        <td class="w-35">
                                                                            <p><a
                                                                                    href="product-details.html">{{ ucfirst($ca['product_name']) }}</a>
                                                                            </p>
                                                                        </td>
                                                                        <td class="text-center p_left">
                                                                            {{ $dim }}
                                                                        </td>

                                                                        <td class="text-center p_left">
                                                                        <span class="shp__price text-primary">£
                                                                            {{ $ca['price'] }}</span>
                                                                        </td>
                                                                        <td>
                                                                            {{-- <div class="remove__btn">
                                                                                <a href="javascript:;"
                                                                                    onclick="removeCartItem({{ $productId }},'{{ $dim }}')"
                                                                                    title="Remove this item"><i
                                                                                        class="zmdi zmdi-close link-primary"></i></a>
                                                                            </div> --}}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <ul class="shoping__total">
                                            <li class="subtotal">Subtotal:</li>
                                            <li class="total__price text-primary">£{{ $subtotal }}</li>
                                        </ul>
                                        <ul class="shoping__total">
                                            <li class="subtotal">Total:</li>
                                            <li class="total__price text-primary"><span>£</span><span
                                                    class="total_price">{{ $subtotal }}</span></li>
                                        </ul>
                                        <input type="hidden" id="total_price" value="{{ $subtotal }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    @endif
@endsection
@section('page_level_js')

    <script src="{{ asset('front/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
    <script src="{{ asset('front/js/slick.min.js') }}"></script>
    <script src="{{ asset('front/js/countrystatecity.js') }}"></script>
    <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js"></script>
    <script>
        $(document).ready(function() {
                @if(isset(Auth::user()->country_short_name)  || isset(Auth::user()->country_short_code )){
                countryCode = "{{Auth::user()->country_short_name}}";
                $("#phone_number").intlTelInput("setCountry", countryCode);
                $("#phone_number").val("{{Auth::user()->phone_number}}");
            }
                @endif
            var validator = $("#addForm").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    phone: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    country: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    zip_code: {
                        required: true
                    },
                    user_card_name: {
                        required: true
                    },
                    user_card_no: {
                        required: true
                    },
                    exp_month: {
                        required: true
                    },
                    exp_year: {
                        required: true
                    },


                },

                errorPlacement: function(error, element) {
                    // $('.main_error').html('All Fields Required!');
                    // var elem = $(element);
                    if (elem.hasClass("first_name") || elem.hasClass("last_name") || elem
                            .hasClass("email") || elem
                            .hasClass("phone") || elem
                            .hasClass("address") || elem
                            .hasClass("card_owner") || elem
                            .hasClass("card_no") ||
                        elem
                            .hasClass("exp_month") || elem
                            .hasClass("exp_year")) {
                        $('.main_error').html('All fields are required!');
                    }
                }
            });
        });
        /*$(document).on('click', '.order_btn', function() {
            //var url = "{{  url('') }}{{'/store/'.$store->slug}}";
            // alert(url);return;
            var validate = $('#confirmOrderForm').valid();
            var totalPrice = $('#total_price').val();
            var form = $('#confirmOrderForm')[0];
            var slug = "{{ $store->slug }}";
            var store_id = "{{ $store->id }}";
            var form_data = new FormData(form);
            form_data.append('slug', slug);
            form_data.append('store_id', store_id);
            form_data.append('totalPrice', totalPrice);
            if (validate) {
                $.ajax({
                    type: "POST",
                    //enctype: 'multipart/formq-data',
                    url: "{{ route('confirmOrder') }}", // your php file name
                    data: form_data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $('.order_btn').prop('disabled',true);
                    },
                    success: function(data) {
                        if (data.status == 'success') {
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
                            window.setTimeout(function() {
                                //window.location  ="{{  url('') }}{{'/store/'.$store->slug}}";

                            }, 3000);
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
                            $('.order_btn').prop('disabled',false);
                        }
                        $('.order_btn').prop('disabled',false);

                    },
                    error: function(errorString) {
                        // Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                    }
                });
            }
        });*/

        function validate() {

            var number = $("#phone_number").intlTelInput('getNumber');
            iso = $("#phone_number").intlTelInput('getSelectedCountryData').iso2;
            var exampleNumber = intlTelInputUtils.getExampleNumber(iso, 0, 0);
            if (number == '')
                number = exampleNumber;

            var formattedNumber = intlTelInputUtils.formatNumber(number, iso, intlTelInputUtils.numberFormat.NATIONAL);
            var isValidNumber = intlTelInputUtils.isValidNumber(number, iso);
            var validationError = intlTelInputUtils.getValidationError(number, iso);

            console.log(number);
            console.log(formattedNumber);
            console.log(intlTelInputUtils.formatNumber(number, iso, intlTelInputUtils.numberFormat.INTERNATIONAL));
            console.log(intlTelInputUtils.formatNumber(number, iso, intlTelInputUtils.numberFormat.E164));
            console.log(intlTelInputUtils.formatNumber(number, iso, intlTelInputUtils.numberFormat.RFC3966));
            console.log(isValidNumber);
            console.log(validationError);

        }


        $("#phone_number").intlTelInput({
            geoIpLookup: function(callback) {
                $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            //hiddenInput: "full_number",
            initialCountry: "auto",
            separateDialCode: true,
            //autoPlaceholder: "off",
        });

        $('#phone_number').on('countrychange', function(e) {

            $(this).val('');
            var selectedCountryCode = $(this).intlTelInput('getSelectedCountryData').iso2;
            var selectedCountry = $(this).intlTelInput('getSelectedCountryData');
            var dialCode = selectedCountry.dialCode;
            var maskNumber = intlTelInputUtils.getExampleNumber(selectedCountry.iso2, 0, 0);
           // console.log("placeholder > " + maskNumber);
            maskNumber = intlTelInputUtils.formatNumber(maskNumber, selectedCountry.iso2, 2);
            //console.log("placeholder > " + maskNumber);
            maskNumber = maskNumber.replace('+' + dialCode + ' ', '');
           // console.log("placeholder > " + maskNumber);
            mask = maskNumber.replace(/[0-9+]/ig, '0');
            //maskPlaceHolder = mask.replace(/[0-9+]/ig, '_');
            $("#selectedcontryname").val(selectedCountryCode);

            $('#phone_number').mask(mask, {
                placeholder: maskNumber
            });
        });
        function getcountrycode(sel)
        {
            var selectcuntrycode = $('.iti__selected-dial-code').html();
            $("#country_short_code").val(selectcuntrycode);
        }
    </script>
@endsection

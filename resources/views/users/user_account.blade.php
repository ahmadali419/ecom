@extends('layouts.template')

@section('title', 'Account')
@section('description', 'User Account')

@section('page_level_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        .tab-menu{}
        .tab-menu ul{
            margin: 0;
            padding: 0;
        }
        .tab-menu ul li{
            list-style-type: none;
            display: inline-block;
        }
        .tab-menu ul li a{
            text-decoration: none;
            color: rgba(0,0,0,0.4);
            background-color: #b4cbc4;
            padding: 7px 25px;
            border-radius: 4px;
        }
        .tab-menu ul li a.active-a{
            background-color: #588d7d;
            color: #ffffff;
        }
        .tab{
            display: none;
        }
        .tab h2{
            color: rgba(0,0,0,.7);
        }
        .tab p{
            color: rgba(0,0,0,0.6);
            text-align: justify;
        }
        .tab-active{
            display: block;
        }

        .profile-pic {
            color: transparent;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            transition: all 0.3s ease;
            width: 165px;
            height: 165px;
            margin: auto;
            margin-bottom: 40px
        }
        .profile-pic input {
            display: none;
        }
        .profile-pic img {
            position: absolute;
            object-fit: cover;
            width: 165px;
            height: 165px;
            box-shadow: 0 0 10px 0 rgba(255, 255, 255, 0.35);
            border-radius: 100px;
            z-index: 0;
        }
        .profile-pic .-label {
            cursor: pointer;
            height: 165px;
            width: 165px;
        }
        .profile-pic:hover .-label {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 10000;
            color: #fafafa;
            transition: background-color 0.2s ease-in-out;
            border-radius: 100px;
            margin-bottom: 0;
        }
        .profile-pic span {
            display: inline-flex;
            padding: 0.2em;
            height: 2em;
        }

        /* collapse Styling : Start */
        .collapse-div {max-width: 100%;min-width:100%}
        summary[role=button] {
            background-color: #f1f1f1;
            color: #252525;
            padding: 1em;
            cursor: pointer
        }
        summary[role=button]:hover, summary[role=button]:focus,
        summary::marker {color: #000}
        details {
            border: 1px solid #000;
            margin-bottom: 0.25em;
            border-radius: 8px;
        }
        details p {padding: 0 1em}
        /* collapse Styling : End */

    </style>
@endsection

@section('content')
    <!-- Start Bradcaump area -->
    <div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0)
        url({{asset('front/images/bg/blinds_banner-1024x429.jpg')}}) no-repeat scroll
        center center / cover ;">
        <div class="ht__bradcaump__wrap">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="bradcaump__inner text-center">
                            <h2 class="bradcaump-title">User Account</h2>
                            <nav class="bradcaump-inner">
                                <a class="breadcrumb-item link-primary" href="index.html">Home</a>
                                <span class="brd-separetor">/</span>
                                <span class="breadcrumb-item active">User</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- cart-main-area start -->
    <section class="htc__product__area shop__page ptb--50 bg__white">
        <div class="container">
            <div class="htc__product__container">
                <!-- Start Product MEnu -->
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12 mt--40">
                        <div class="tab-menu sidebar left-sidebar cust_cart_box s-side-text">
                            <div class="sidebar-title clearfix">
                                <div class="shp__pro__thumb margin-0 width-100">
                                    <a class=" d-flex justify-content-center width-100">
                                        @if(!empty(Auth::user()->photo))
                                        <img class="img-rounded" src="{{asset('user/profile').'/'.Auth::user()->photo}}" alt="user image">
                                        @else
                                            <img class="img-rounded" src="{{asset('front/images/bg/images.png')}}" alt="user image">
                                        @endif
                                    </a>
                                </div>
                                <h3 class="floatleft h7-heading text-secondary text-center mt--20">{{!empty(Auth::user()->name) ? Auth::user()->name:''}}</h3>
                            </div>
                            <hr class="line-divider">

                            <a data-id="tab2" class="tab-a active-a btn-secondary-outer text-center width-100 d-flex justify-content-between mb--10">
                                <span class="ti-user icon-size-6"></span>
                                <span>Profile</span>
                            </a>

                            <a data-id="tab1" class="tab-a  btn-secondary-outer text-center width-100 d-flex justify-content-between mb--10">
                                <span class="ti-shopping-cart icon-size-6"></span>
                                <span>Order History</span>
                            </a>

                           {{-- <a data-id="tab3" class="tab-a btn-secondary-outer text-center width-100 d-flex justify-content-between mb--10">
                                <span class="ti-shift-right icon-size-6"></span>
                                <span>Log Out</span>
                            </a>--}}

                            <!-- </ul> -->
                        </div><!--end of tab-menu-->
                    </div>

                    <div class="col-md-8 col-sm-8 col-xs-12 mt--40">
                        <div  class="tab " data-id="tab1">

                            <div class="right-products">

                                <div class="cust_cart_box ckeckout-page ckeckout-left-sidebar mb--30">

                                    <div class="d-flex justify-content-between align-content-center">
                                        <h2 class="title__line text-primary">Order History</h2>
                                        <div class="single-checkout-box select-option">
                                            <select class="width-100" name="order_status" onchange="filterStatus(this.value)">
                                                <option value="all">Select All</option>
                                                <option value="pending">Pending Orders</option>
                                                <option value="completed">Complete Orders</option>
                                                <option value="declined">Declined Orders</option>
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="line-divider">

                                    <div class="collapse-div">
                                        @if(!empty($userOrder))
                                        @foreach($userOrder as $Order)
                                        <details>
                                            <summary role="button" tabindex="0" class="row margin-0">
                                                <span class="col-md-3 col-sm-6 col-xs-6 mt--10">{{$Order->id}}</span>
                                                <span class="col-md-3 col-sm-6 col-xs-6 text-right mt--10">{{date('d/m/Y',strtotime($Order->created_at))}}</span>
                                                <span class="col-md-3 col-sm-6 col-xs-6 text-center padding-1 bg-primary img-rounded border-0">
                                                               {{ucfirst($Order->status)}}
                                                            </span>
                                                <span class="col-md-3 col-sm-6 col-xs-6 ti-arrow-down text-right mt--10"></span>
                                            </summary>

                                            <div class="padding-4">


                                                <div>
                                                    @foreach($Order->orderdetail as $orderItem)
                                                    <div class="shp__single__product">
                                                        <div class="row width-100">
                                                            <div class="col-lg-9 col-md-9 col-sm-12">
                                                                <div class="shp__pro__thumb mb--10">
                                                                    <a href="#">
                                                                        <img
                                                                            src="{{ asset('product/coverimage') . '/' . $orderItem->orderProducts->main_image }}"
                                                                            alt="product images">
                                                                    </a>
                                                                </div>
                                                                <div class="shp__pro__details">
                                                                    <h2>{{ucfirst($orderItem->orderProducts->name)}}</h2>
                                                                    <span class="shp__price text-primary">£ {{$orderItem->price}}</span>
                                                                    <div class="shp__pro__details">
                                                                        <h2>Dimensions</h2>
                                                                        <span class="">{{$orderItem->dimension}}</span>
                                                                        <h6 class="fittings-txt">Qty: <span>{{floor($orderItem->qty)}}</span></h6>
                                                                        <h6 class="text-primary">Measurement: <span>{{ucfirst($orderItem->scale)}}</span></h6>
                                                                        @if(!empty($orderItem->fitting_type))
                                                                        <h6 class="fittings-txt">Fittings: <span>{{ucfirst($orderItem->fitting_type)}}</span></h6>
                                                                        @endif
                                                                        @if(!empty($orderItem->chain_color))
                                                                        <h6 class="fittings-txt">Chain Color: <span>{{ucfirst($orderItem->chain_color)}}</span></h6>
                                                                        @endif
                                                                        @if(!empty($orderItem->side_control))
                                                                        <h6 class="fittings-txt">Side Controls: <span>{{ucfirst($orderItem->side_control)}}</span></h6>
                                                                        @endif
                                                                        @if(!empty($orderItem->fitting_option))
                                                                        <h6 class="fittings-txt">Fitting Option: <span>{{ucfirst($orderItem->fitting_option)}}</span></h6>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>


                                                <ul class="shoping__total padding-0 mb--10">
                                                    <li class="subtotal">Total:</li>
                                                    <li class="total__price text-primary">£{{$Order->total_price}}</li>
                                                </ul>



                                            </div>


                                        </details>
                                        @endforeach
                                        @else
                                            <h5>Sorry No Record Found!</h5>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div><!--end of tab one-->
                    </div>


                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div  class="tab tab-active" data-id="tab2">

                            <div class="right-products">
                                <form method="post" id="user_account">
                                    <input type="hidden" class="form-control" name="selectedcontryname" id="selectedcontryname" value="" />
                                <div class="cust_cart_box ckeckout-page ckeckout-left-sidebar mb--30">

                                    <div class="shp__single__product mb--0">
                                        <div class="width-100">

                                            <div class="profile-pic">
                                                <label class="-label" for="file">
                                                    <span class="ti-camera text-white mt--10"></span>
                                                    <span>Change Image</span>
                                                </label>
                                                <input id="file" name="user_image" type="file" onchange="loadFile(event)"/>
                                                @if(!empty(Auth::user()->photo))
                                                    <input type="hidden" name="old_image" value="{{Auth::user()->photo}}"/>
                                                <img src="{{asset('user/profile').'/'.Auth::user()->photo}}" id="output" width="200" />
                                                @else
                                                    <img src="https://cdn.pixabay.com/photo/2017/08/06/21/01/louvre-2596278_960_720.jpg" id="output" width="200" />
                                                @endif
                                            </div>


                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input class="pt--10 pb--10 pr-2 pl-2 mb--10" name="name" id="name" value="{{!empty(Auth::user()->name) ? Auth::user()->name:''}}" type="text" placeholder="First Name">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input class="pt--10 pb--10 pr-2 pl-2 mb--10" value="{{!empty(Auth::user()->email) ? Auth::user()->email:''}}" type="email" readonly placeholder="Emil">
                                                </div>
                                                <div class="col-md-6">
                                                    <input class="pt--10 pb--10 pr-2 pl-2 mb--10" type="text" readonly name="u_name" id="u_name" value="{{!empty(Auth::user()->u_name) ? Auth::user()->u_name :''}}"  placeholder="User Name">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input class="pt--10 pb--10 pr-2 mb--10 width-100" type="phone" name="phone" id="phone" value="" placeholder="Phone">
                                                </div>

                                            </div>

                                            <hr class="line-divider">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <textarea class="pt--10 pb--10 pr-2 pl-2 mb--10 bg-white" placeholder="Address" name="address">{{!empty(Auth::user()->address) ? Auth::user()->address:''}}</textarea>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select name="country" id="countryId" class="countries pt--10 pb--10 pr-2 pl-2 mb--10">
                                                        <option value="">Select Country*</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select name="state" class="states pt--10 pb--10 pr-2 pl-2 mb--10" id="stateId">
                                                        <option value="">Select State</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select name="city" class="cities pt--10 pb--10 pr-2 pl-2 mb--10"  id="cityId">
                                                        <option value="">Select City</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <input class="pt--10 pb--10 pr-2 pl-2 mb--10" type="text" name="zip_code" value="{{!empty(Auth::user()->zip_code) ? Auth::user()->zip_code:''}}" required placeholder="Zip Code*">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr class="line-divider">

                                    <div class="buttons-cart mt--20 margin-0 pr-0 pl-0">

                                        <a class="btn-primary" id="update_account">Save</a>
                                    </div>

                                </div>
                                </form>
                            </div>

                        </div><!--end of tab two-->
                    </div>

                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div  class="tab " data-id="tab3">

                            <div class="right-products">
                                <div class="cust_cart_box ckeckout-page ckeckout-left-sidebar mb--30">
                                    <div class="shp__single__product mb--0">
                                        <div class="width-100">
                                            Log Out
                                        </div>
                                    </div>
                                </div>
                            </div>


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
    <script src="{{ asset('front/js/countrystatecity.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
                @if(isset(Auth::user()->country_short_name)  || isset(Auth::user()->country_short_code )){
                countryCode = "{{Auth::user()->country_short_name}}";
                $("#phone").intlTelInput("setCountry", countryCode);
                $("#phone").val("{{Auth::user()->phone_number}}");
            }
            @endif

            $('.tab-a').click(function(){
                $(".tab").removeClass('tab-active');
                $(".tab[data-id='"+$(this).attr('data-id')+"']").addClass("tab-active");
                $(".tab-a").removeClass('active-a');
                $(this).parent().find(".tab-a").addClass('active-a');
            });
        });

        // $('#countryId').val('Pakistan');
        var country="{{!empty(Auth::user()->country) ? Auth::user()->country:''}}";
        var state="{{!empty(Auth::user()->state) ? Auth::user()->state:''}}";
        var city="{{!empty(Auth::user()->city) ? Auth::user()->city : ''}}";

        $('#countryId').append("<option value="+country+" selected>"+country+"</option>");
        $('#stateId').append("<option value="+state+" selected>"+state+"</option>");
        $('#cityId').append("<option value="+city+" selected>"+city+"</option>");

        var loadFile = function (event) {
            var image = document.getElementById("output");
            image.src = URL.createObjectURL(event.target.files[0]);
        };
        jQuery(document).ready(function() {
            var validator = $("#user_account").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    name: {
                        required: true
                    },
                    u_name: {
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
                    state: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    zip_code: {
                        required: true
                    }


                },
                errorPlacement: function (error, element) {
                    var elem = $(element);
                    if (elem.hasClass("selectpicker")) {
                        element = elem.parent();
                        error.insertAfter(element);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            $(document).on('click', '#update_account', function () {
               var validate = $("#user_account").valid();
                var selectcuntrycode = $('.iti__selected-dial-code').html();
                if (validate) {
                    var form = $("#user_account")[0];
                    var form_data = new FormData(form);
                    form_data.append('selectcuntrycode', selectcuntrycode);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('updateProfile') }}", // your php file name
                        data: form_data,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {

                            if (res.status == 'error') {

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
                                toastr.warning(res.message);


                            } else if (res.status == 'success') {

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
                                toastr.success(res.message);

                            }
                        },
                        error: function (errorString) {
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
                            toastr.warning("Sorry!", "Something went wrong please contact to admin", "error");
                        }
                    });
                }
            });
        });

        function filterStatus(status)
        {
            var form_data = new FormData();
            form_data.append('order_status',status);

            $.ajax({
                type: "POST",
                url: "{{route('filterStatus')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data){
                    $('.collapse-div').html('');
                    $('.collapse-div').html(data.html);


                },
                error: function (errorString){
                    alert('contact to admin');
                }
            });
        }
    </script>
    <script>
        function validate() {

            var number = $("#phone").intlTelInput('getNumber');
            iso = $("#phone").intlTelInput('getSelectedCountryData').iso2;

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


        //var input = document.querySelector("#phone");

        $("#phone").intlTelInput({
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

        $('#phone').on('countrychange', function(e) {

            $(this).val('');
            var selectedCountryCode = $(this).intlTelInput('getSelectedCountryData').iso2;
            var selectedCountry = $(this).intlTelInput('getSelectedCountryData');
            var dialCode = selectedCountry.dialCode;
            var maskNumber = intlTelInputUtils.getExampleNumber(selectedCountry.iso2, 0, 0);
           // console.log("placeholder" + maskNumber);
            maskNumber = intlTelInputUtils.formatNumber(maskNumber, selectedCountry.iso2, 2);
          //  console.log("placeholder" + maskNumber);
            maskNumber = maskNumber.replace('+' + dialCode + ' ', '');
         //   console.log("placeholder" + maskNumber);
            mask = maskNumber.replace(/[0-9+]/ig, '0');
            //maskPlaceHolder = mask.replace(/[0-9+]/ig, '_');
            $("#selectedcontryname").val(selectedCountryCode);

            $('#phone').mask(mask, {
                placeholder: maskNumber
            });
        });
    </script>

@endsection


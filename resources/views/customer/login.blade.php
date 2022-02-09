@extends('layouts.template')

@section('title', 'Login')
@section('description', 'Customer Login')

@section('page_level_css')
@endsection

@section('content')
<div class="htc__login__register bg__white ptb--130" style="background: #fff;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="d-flex justify-content-center width-60 margin-auto text-center" role="tablist">
                    <a class="btn-primary text-center width-50 margin-2" href="#login" role="tab" data-toggle="tab">Login</a>
                    <a class="btn-secondary-outer text-center width-50 margin-2" href="#register" role="tab" data-toggle="tab">Register</a>
                </div>
            </div>
        </div>
        <!-- Start Login Register Content -->
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="htc__login__register__wrap">
                    <!-- Start Single Content -->
                    <div id="login" role="tabpanel" class="single__tabs__panel tab-pane fade in active">
                        <form class="login" id="login_form" method="post">
                            <input type="hidden" name="store_id" value="{{$storeSetting->id}}">
                            <input type="text" name="u_name" id="u_name" placeholder="User Name*">
                            <input type="password" name="password" id="user_password" placeholder="Password*">

                        <div class="tabs__checkbox">
                            <input type="checkbox">
                            <span> Remember me</span>
                            <span class="forget"><a class="text-primary" href="#">Forget Pasword?</a></span>
                        </div>
                        <div class="d-flex width-100">
                            <a class="btn-primary width-100 text-center" id="btn_save">Login</a>
                        </div>
                        </form>
                        <!-- <div class="htc__login__btn mt--30">
                            <a href="#">Login</a>
                        </div> -->
                        <div class="htc__social__connect">
                            <h2>Or Login With</h2>
                            <ul class="htc__soaial__list">
                                <li><a class="bg--twitter" href="#"><i class="zmdi zmdi-twitter"></i></a></li>

                                <li><a class="bg--instagram" href="#"><i class="zmdi zmdi-instagram"></i></a></li>

                                <li><a class="bg--facebook" href="#"><i class="zmdi zmdi-facebook"></i></a></li>

                                <li><a class="bg--googleplus" href="#"><i class="zmdi zmdi-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Single Content -->
                    <!-- Start Single Content -->
                    <div id="register" role="tabpanel" class="single__tabs__panel tab-pane fade">
                        <form method="POST" id="signup_form" class="login" >

                            <input type="hidden" name="store_id" value="{{$storeSetting->id}}">
                            <input type="text" class="@error('name') is-invalid @enderror" name="name" placeholder="Name*" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <input type="text"  class="@error('u_name') is-invalid @enderror" name="u_name" value="{{ old('u_name') }}" required  placeholder="User Name*">
                            @error('u_name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <input type="email"  class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required  placeholder="Email*">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <input type="password" class="@error('password') is-invalid @enderror" name="password" required  placeholder="Password*">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password*">



                        <div class="d-flex width-100">
                            <button class="btn-primary width-100 text-center" type="button" id="btn_signup" > {{ __('Register') }}</button>
                        </div>

                        </form>
                        <div class="htc__social__connect">
                            <h2>Or Login With</h2>
                            <ul class="htc__soaial__list">
                                <li><a class="bg--twitter" href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                                <li><a class="bg--instagram" href="#"><i class="zmdi zmdi-instagram"></i></a></li>
                                <li><a class="bg--facebook" href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                                <li><a class="bg--googleplus" href="#"><i class="zmdi zmdi-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Single Content -->
                </div>
            </div>
        </div>
        <!-- End Login Register Content -->
    </div>
</div>
@endsection
@section('page_level_js')
    <script src="{{ asset('front/js/plugins.js') }}"></script>
    <script src="{{ asset('front/js/slick.min.js') }}"></script>
    <script src="{{ asset('front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            //datatable.init();

            var validator = $("#login_form").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    u_name: {
                        required: true
                    },
                    password: {
                        required: true
                    }


                },
                errorPlacement: function(error, element) {
                    var elem = $(element);
                    if (elem.hasClass("selectpicker")) {
                        element = elem.parent();
                        error.insertAfter(element);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            var validator = $("#signup_form").validate({
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
                    password: {
                        required: true
                    },
                    password_confirmation: {
                        required: true
                    }


                },
                errorPlacement: function(error, element) {
                    var elem = $(element);
                    if (elem.hasClass("selectpicker")) {
                        element = elem.parent();
                        error.insertAfter(element);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });




           $(document).on('click', '#btn_save', function(){
                var validate = $("#login_form").valid();
                if(validate) {
                   var form_data = $("#login_form").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('login') }}", // your php file name
                        data: form_data,
                       headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {
                            console.log(res);
                            if (res== 'errors') {

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


                            } else if(res.auth) {

                                window.location.href = "{{route('store.slug',[$storeSetting->slug])}}";

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
           $(document).on('click', '#btn_signup', function(){
               var validate = $("#signup_form").valid();
                if(validate) {
                    var form_data = $("#signup_form").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('register') }}", // your php file name
                        data: form_data,
                        dataType: "json",
                       headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {
                            console.log(res);
                            if (res.status== 'error') {

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


                            } else if(res.status=='success') {

                                window.location.href = "{{route('store.slug',[$storeSetting->slug])}}";

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
    </script>
@endsection

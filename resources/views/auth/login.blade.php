@extends('layouts.auth')

@section('title', 'Login')
@section('description', 'Login Page')

@section('page_level_css')
    <link href="{{ asset('assets/css/pages/login/classic/login-4.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
        <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('assets/media/bg/bg-3.jpg');">
            <div class="login-form text-center p-7 position-relative overflow-hidden">
                <!--begin::Login Header-->
                <div class="d-flex flex-center mb-15">
                    <a href="#">
                        <img src="{{ asset('assets/media/logos/logo-letter-13.png') }}" class="max-h-75px" alt="" />
                    </a>
                </div>
                <!--end::Login Header-->
                <!--begin::Login Sign in form-->
                <div class="login-signin">
                    <div class="mb-20">
                        <h3>Sign In To Admin</h3>
                        <div class="text-muted font-weight-bold">Enter your details to login to your account:</div>
                    </div>
                    <form class="form" id="kt_login_signin_form">
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="User Name" name="u_name" autocomplete="off" />
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" />
                        </div>
                        <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                            <label class="checkbox m-0 text-muted">
                                <input type="checkbox" name="remember" />Remember me
                                <span></span></label>
                            <a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary">Forget Password ?</a>
                        </div>
                        <button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Sign In</button>
                    </form>
                    <div class="mt-10">
{{--                        <span class="opacity-70 mr-4">Don't have an account yet?</span>--}}
{{--                        <a href="javascript:;" id="kt_login_signup" class="text-muted text-hover-primary font-weight-bold">Sign Up!</a>--}}
                    </div>
                </div>
                <!--end::Login Sign in form-->
                <!--begin::Login Sign up form-->
                <div class="login-signup">
                    <div class="mb-20">
                        <h3>Sign Up</h3>
                        <div class="text-muted font-weight-bold">Enter your details to create your account</div>
                    </div>
                    <form class="form" id="kt_login_signup_form">
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Fullname" name="fullname" />
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" />
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Confirm Password" name="cpassword" />
                        </div>
                        <div class="form-group mb-5 text-left">
                            <label class="checkbox m-0">
                                <input type="checkbox" name="agree" />I Agree the
                                <a href="#" class="font-weight-bold">terms and conditions</a>.
                                <span></span></label>
                            <div class="form-text text-muted text-center"></div>
                        </div>
                        <div class="form-group d-flex flex-wrap flex-center mt-10">
                            <button id="kt_login_signup_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Sign Up</button>
                            <button id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</button>
                        </div>
                    </form>
                </div>
                <!--end::Login Sign up form-->
                <!--begin::Login forgot password form-->
                <div class="login-forgot">
                    <div class="mb-20">
                        <h3>Forgotten Password ?</h3>
                        <div class="text-muted font-weight-bold">Enter your email to reset your password</div>
                    </div>
                    <form class="form" id="kt_login_forgot_form">
                        <div class="form-group mb-10">
                            <input class="form-control form-control-solid h-auto py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
                        </div>
                        <div class="form-group d-flex flex-wrap flex-center mt-10">
                            <button id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Request</button>
                            <button id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</button>
                        </div>
                    </form>
                </div>
                <!--end::Login forgot password form-->
            </div>
        </div>
    </div>
@endsection

@section('page_level_js')
    <script type="text/javascript">
        // Class Definition
        var KTLogin = function() {
            var _login;

            var _showForm = function(form) {
                var cls = 'login-' + form + '-on';
                var form = 'kt_login_' + form + '_form';

                _login.removeClass('login-forgot-on');
                _login.removeClass('login-signin-on');
                _login.removeClass('login-signup-on');

                _login.addClass(cls);

                KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
            }

            var _handleSignInForm = function() {
                var validation;

                // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                validation = FormValidation.formValidation(
                    KTUtil.getById('kt_login_signin_form'),
                    {
                        fields: {
                            u_name: {
                                validators: {
                                    notEmpty: {
                                        message: 'Email is required'
                                    },
                                }
                            },
                            password: {
                                validators: {
                                    notEmpty: {
                                        message: 'Password is required'
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            submitButton: new FormValidation.plugins.SubmitButton(),
                            //defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
                            bootstrap: new FormValidation.plugins.Bootstrap()
                        }
                    }
                );

                $('#kt_login_signin_submit').on('click', function (e) {
                    e.preventDefault();

                    validation.validate().then(function(status) {
                        if (status == 'Valid') {
                            var formData = new FormData($('#kt_login_signin_form')[0]);
                            $.ajax({
                                url: '{{ route('login') }}',
                                data: formData,
                                type: 'POST',
                                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                                processData: false, // NEEDED, DON'T OMIT THIS
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(res) {
                                    if(res.errors) {
                                        swal.fire({
                                            text: res.message,
                                            icon: "error",
                                            buttonsStyling: false,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn font-weight-bold btn-light-primary"
                                            }
                                        }).then(function() {
                                            KTUtil.scrollTop();
                                        });
                                    } else if(res.auth) {
                                        window.location.href = "{{ route('home') }}";
                                    }
                                },
                                error: function() {
                                    swal.fire({
                                        text: "Sorry, something went wrong contact to admin.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn font-weight-bold btn-light-primary"
                                        }
                                    }).then(function() {
                                        KTUtil.scrollTop();
                                    });
                                }
                            });
                        } else {
                            swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function() {
                                KTUtil.scrollTop();
                            });
                        }
                    });
                });

                // Handle forgot button
                $('#kt_login_forgot').on('click', function (e) {
                    e.preventDefault();
                    _showForm('forgot');
                });

                // Handle signup
                $('#kt_login_signup').on('click', function (e) {
                    e.preventDefault();
                    _showForm('signup');
                });
            }

            var _handleSignUpForm = function(e) {
                var validation;
                var form = KTUtil.getById('kt_login_signup_form');

                // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                validation = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            fullname: {
                                validators: {
                                    notEmpty: {
                                        message: 'Username is required'
                                    }
                                }
                            },
                            email: {
                                validators: {
                                    notEmpty: {
                                        message: 'Email address is required'
                                    },
                                    emailAddress: {
                                        message: 'The value is not a valid email address'
                                    }
                                }
                            },
                            password: {
                                validators: {
                                    notEmpty: {
                                        message: 'The password is required'
                                    }
                                }
                            },
                            cpassword: {
                                validators: {
                                    notEmpty: {
                                        message: 'The password confirmation is required'
                                    },
                                    identical: {
                                        compare: function() {
                                            return form.querySelector('[name="password"]').value;
                                        },
                                        message: 'The password and its confirm are not the same'
                                    }
                                }
                            },
                            agree: {
                                validators: {
                                    notEmpty: {
                                        message: 'You must accept the terms and conditions'
                                    }
                                }
                            },
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap()
                        }
                    }
                );

                $('#kt_login_signup_submit').on('click', function (e) {
                    e.preventDefault();

                    validation.validate().then(function(status) {
                        if (status == 'Valid') {
                            swal.fire({
                                text: "All is cool! Now you submit this form",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function() {
                                KTUtil.scrollTop();
                            });
                        } else {
                            swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function() {
                                KTUtil.scrollTop();
                            });
                        }
                    });
                });

                // Handle cancel button
                $('#kt_login_signup_cancel').on('click', function (e) {
                    e.preventDefault();

                    _showForm('signin');
                });
            }

            var _handleForgotForm = function(e) {
                var validation;

                // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                validation = FormValidation.formValidation(
                    KTUtil.getById('kt_login_forgot_form'),
                    {
                        fields: {
                            email: {
                                validators: {
                                    notEmpty: {
                                        message: 'Email address is required'
                                    },
                                    emailAddress: {
                                        message: 'The value is not a valid email address'
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap()
                        }
                    }
                );

                // Handle submit button
                $('#kt_login_forgot_submit').on('click', function (e) {
                    e.preventDefault();

                    validation.validate().then(function(status) {
                        if (status == 'Valid') {
                            // Submit form
                            KTUtil.scrollTop();
                        } else {
                            swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn font-weight-bold btn-light-primary"
                                }
                            }).then(function() {
                                KTUtil.scrollTop();
                            });
                        }
                    });
                });

                // Handle cancel button
                $('#kt_login_forgot_cancel').on('click', function (e) {
                    e.preventDefault();

                    _showForm('signin');
                });
            }

            // Public Functions
            return {
                // public functions
                init: function() {
                    _login = $('#kt_login');

                    _handleSignInForm();
                    _handleSignUpForm();
                    _handleForgotForm();
                }
            };
        }();

        // Class Initialization
        jQuery(document).ready(function() {
            KTLogin.init();
        });
    </script>
@endsection

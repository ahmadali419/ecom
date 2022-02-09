@extends('layouts.app')

@section('title', 'User')
@section('description', 'User Description')

@section('page_level_css_plugins')
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.4') }}" rel="stylesheet"
    type="text/css" />
@endsection

@section('page_level_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<style>
    .iti.iti--allow-dropdown.iti--separate-dial-code,.iti{
        width: 100%!important;
    }.iti--allow-dropdown input, .iti--allow-dropdown input[type=text], .iti--allow-dropdown input[type=tel], .iti--separate-dial-code input, .iti--separate-dial-code input[type=text], .iti--separate-dial-code input[type=tel] {
         padding-left: 85px!important;
     }
    .iti__country-list {
        width: 332px!important;
    }
    .iti__flag-container{
        padding: 12px;
    }

    .iti__selected-flag {}
    .card{
        border: 1px solid #f2eeee !important;
    }
    .colorDisable{
        background-color: #F3F6F9 !important;
    }
</style>
@endsection
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="row">
                <div class="card card-custom col-lg-7 col-12">
                    <div class="card-header">
                        <div class="card-title">
                        <h3 class="card-label">Edit Profile</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form onsubmit="return false" id="addForm">
                            <input type="hidden" class="form-control" name="selectedcontryname" id="selectedcontryname" value="" />
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="col-form-label">Full Name *</label>
                                    <input required type="text" class="form-control" name="name" value="{{(Auth::check()) ? Auth::user()->name : ''}}" id="name" placeholder="Enter name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label">User Name *</label>
                                    <input required type="text" class="form-control colorDisable" value="{{(Auth::check()) ? Auth::user()->u_name : ''}}" name="u_name" id="u_name" readonly
                                        placeholder="Enter user name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label">Email *</label>
                                    <input required type="email" class="form-control colorDisable" value="{{(Auth::check()) ? Auth::user()->email : ''}}" name="email" id="email" readonly
                                        placeholder="Enter email name" />
                                </div>
                                <div class="col-md-6">
                                    <label class="col-12 col-form-label">Phone Number</label>
                                    <input required type="text" class="form-control" value="{{Auth::user()->phone_number}}" autocomplete="off" data-intl-tel-input-id="0" name="phone" id="phone"
                                        placeholder="Enter phone number" />
                                </div>
                                <div class="col-md-6">
                                    <label for="country">Country:<span class="text-danger">*</span></label>
                                    <select required name="country" id="countryId" class="form-control countries pt--10 pb--10 pr-2 pl-2 mb--10">
                                        <option value="">Select Country*</option>
                                        @if(!empty(Auth::user()->country))
                                            <option selected value="{{ !empty(Auth::user()->country) ? Auth::user()->country : '' }}">{{Auth::user()->country}}</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="state">State:<span class="text-danger">*</span></label>
                                    <select required name="state" class="form-control states pt--10 pb--10 pr-2 pl-2 mb--10" id="stateId">
                                        @if(!empty(Auth::user()->state))
                                            <option value="{{ !empty(Auth::user()->state) ? Auth::user()->state : '' }}">{{Auth::user()->state}}</option>
                                        @else
                                            <option value="">Select State</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="city">City: <span class="text-danger">*</span></label>
                                    <select required name="city" class="form-control cities pt--10 pb--10 pr-2 pl-2 mb--10"  id="cityId">
                                        @if(!empty(Auth::user()->city))
                                            <option value="{{ !empty(Auth::user()->city) ? Auth::user()->city : '' }}">{{Auth::user()->city}}</option>
                                        @else
                                            <option value="">Select City</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="zipcode">Zip Code: <span
                                            class="text-danger">*</span></label>
                                    <input required type="text" class="form-control" name="zip_code" id="zip_code"
                                           value="{{ !empty(Auth::user()->zip_code) ? Auth::user()->zip_code : '' }}"
                                           required>
                                </div>
                                <div class="col-md-12">
                                    <label class="col-form-label">Profile Photo</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="upload-image-site" id="image1"
                                                name="user_image" /><br />
                                            @if(!empty(Auth::user()->photo))
                                            <div id="frames1">
                                                <img src="{{asset('user/profile/').'/'.Auth::user()->photo}}" style="margin-top:20px; text-align:center" width="50px" height="50px"/>
                                            </div>
                                            @else
                                                <div id="frames1"></div>
                                            @endif
                                            <input type="hidden" value="" name="old_image" id="old_image">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-primary  font-weight-bold" id="btn_save">Update</button>
                        <button type="button" class="btn btn-light-primary ml-2 font-weight-bold">Close</button>
                    </div>
                </div>
                <div class="card card-custom col-lg-4 ml-5 col-12">
                    <div class="card-header">
                        <div class="card-title">
                        <h3 class="card-label">Change Password</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form onsubmit="return false" id="passwordform">
                            <div class="row mb-2">
                                <div class="col-md-8">
                                    <label class="col-form-label">Current Password *</label>
                                    <input type="password" class="form-control" name="currentpassword" id="currentpassword" placeholder="Enter Current Password" required />
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label">New Password *</label>
                                    <input type="password" class="form-control"  name="newpassword" id="newpassword"
                                        placeholder="Enter New Password" required />
                                </div>
                                <div class="col-md-8">
                                    <label class="col-form-label">Confirm Password *</label>
                                    <input type="password" name="cpassword" id="cpassword" class="form-control"
                                        placeholder="Enter Password" required />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-primary  font-weight-bold" id="btn_password">Update</button>
                        <button type="button" class="btn btn-light-primary ml-2 font-weight-bold">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('page_level_js_plugins')
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4') }}"></script>
<script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
@endsection
@section('page_level_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js"></script>
<script src="{{ asset ('assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4') }}"></script>
<script src="{{ asset('front/js/countrystatecity.js') }}"></script>
<script type="text/javascript">
$(document).ajaxStart(function() {
    KTApp.blockPage({
        overlayColor: 'red',
        opacity: 0.1,
        state: 'primary' // a bootstrap color
    });
}).ajaxStop(function() {
    KTApp.unblockPage();
});

    $(document).on('click', '#btn_save', function() {
        var validate = $("#addForm").valid();
        if (validate) {
            //var form_data = $("#addForm").serializeArray();
            var form = $('#addForm')[0];
            var selectcuntrycode = $('.iti__selected-dial-code').html();
            var form_data = new FormData(form);
            form_data.append('selectcuntrycode', selectcuntrycode);
            $.ajax({
                type: "POST",
                url: "{{route('updateProfile')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                        setTimeout(function()
                        {
                            location.reload();  //Refresh page
                        }, 5000);
                    } else {
                        //  toastr.danger(data.message);
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin",
                        "error");
                }
            });
        }
    });
    var input = document.getElementById("addForm");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("btn_save").click();
        }
    });


function resetForm() {
    $('#addForm')[0].reset();
    $('#id').val("");
    $('#brand_id').val("").trigger('change');
}
$(document).ready(function() {
        @if(isset(Auth::user()->country_short_name)  || isset(Auth::user()->country_short_code )){
        countryCode = "{{Auth::user()->country_short_name}}";
        $("#phone").intlTelInput("setCountry", countryCode);
        $("#phone").val("{{Auth::user()->phone_number}}");
    }
    @endif
    $('#image1').change(function() {
        $("#frames1").html('');
        for (var i = 0; i < $(this)[0].files.length; i++) {
            $("#frames1").append('<img src="' + window.URL.createObjectURL(this.files[i]) +
                '" style="margin-top:20px; text-align:center" width="50px" height="50px"/>');
        }
    });
});
$(document).on('click', '#btn_password', function() {
    var newpass = $("#newpassword").val();
    var cpass = $("#cpassword").val();
    if(newpass==cpass){
        var validate = $("#passwordform").valid();
        if (validate) {
            //var form_data = $("#addForm").serializeArray();
            var form = $('#passwordform')[0];
            var form_data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{route('userPassword')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                        table.ajax.reload();
                    } else {
                        //  toastr.danger(data.message);
                        Swal.fire("Sorry!", data.message, "error");
                    }
                },
                error: function(errorString) {
                    Swal.fire("Sorry!", "Something went wrong please contact to admin",
                        "error");
                }
            });
        }
    }else{
            Swal.fire("Sorry!", "New password And Confirm Password should be same",
                "error");
        return false;
    }
});




function validate() {

var number = $("#phone").intlTelInput('getNumber');
iso = $("#phone").intlTelInput('getSelectedCountryData').iso2;
var exampleNumber = intlTelInputUtils.getExampleNumber(iso, 0, 0);
if (number == '')
    number = exampleNumber;

var formattedNumber = intlTelInputUtils.formatNumber(number, iso, intlTelInputUtils.numberFormat.NATIONAL);
var isValidNumber = intlTelInputUtils.isValidNumber(number, iso);
var validationError = intlTelInputUtils.getValidationError(number, iso);


}


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
        console.log("placeholder > " + maskNumber);
        maskNumber = intlTelInputUtils.formatNumber(maskNumber, selectedCountry.iso2, 2);
        console.log("placeholder > " + maskNumber);
        maskNumber = maskNumber.replace('+' + dialCode + ' ', '');
        console.log("placeholder > " + maskNumber);
        mask = maskNumber.replace(/[0-9+]/ig, '0');
        //maskPlaceHolder = mask.replace(/[0-9+]/ig, '_');
            $("#selectedcontryname").val(selectedCountryCode);
        $('#phone').mask(mask, {
            placeholder: maskNumber
        });
});

</script>
@endsection

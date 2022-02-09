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
    </style>
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                        <span class="card-icon svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\General\User.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path
                                        d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                            <h3 class="card-label">Customer List</h3>
                        </div>

                    </div>
                    <div class="card-body">
                        <!--begin: Search Form-->
                        <form class="kt-form kt-form--fit mb-15">
                            <div class="row mb-6">
                                <div class="col-lg-3 mb-lg-3 mb-2">
                                    <div class="form-group">
                                        <div class="w-100">
                                            <label for="exampleSelectd">Store<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="w-100">
                                            <select class="form-control select2 kt-select2-general categories  datatable-input" id="store_id_search"  data-col-index="0" >
                                                <option value="" selected>Select Store</option>
                                                @foreach($stores as $store)
                                                    <option value="{{$store->id}}">{{$store->name}}</option>
                                                @endforeach;

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-lg-0 mb-6">
                                    <label>Email:</label>
                                    <input type="email" class="form-control datatable-input"
                                           placeholder="E.g: test@mail.com" data-col-index="2" />
                                </div>
                                <div class="col-lg-3 mb-lg-0 mb-6">
                                    <label>Name:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="E.g: name"
                                           data-col-index="3" />
                                </div>
                                <div class="col-lg-3 mb-lg-0 mb-6">
                                    <label>Phone Number:</label>
                                    <input type="text" class="form-control datatable-input"  data-col-index="4"
                                           placeholder="Enter phone number" />
                                    <div class="alert alert-info" style="display: none;"></div>
                                </div>
                                <div class="col-lg-3 mb-lg-0 mb-6">
                                    <label>&nbsp;</label><br />
                                    <button class="btn btn-primary btn-primary--icon" id="kt_search">
                                    <span>
                                        <i class="la la-search"></i>
                                        <span>Search</span>
                                    </span>
                                    </button>&#160;&#160;
                                    <button class="btn btn-secondary btn-secondary--icon" id="kt_reset">
                                    <span>
                                        <i class="la la-close"></i>
                                        <span>Reset</span>
                                    </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <!--begin: Datatable-->
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-hover table-checkable" id="datatableList">
                            <thead>
                            <tr>
                                <th>Sr</th>
                                <th>Store Name</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Sr</th>
                                <th>Store Name</th>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Actions</th>
                            </tr>
                            </tfoot>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <div class="modal fade" id="add_edit_modal" tabindex="-1" role="dialog" aria-labelledby="add_edit_modal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <form onsubmit="return false" id="addForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                        <span class="card-icon svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\General\User.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                        fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                    <path
                                        d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                        fill="#000000" fill-rule="nonzero" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                            User
                        </span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <h6 class="text-dark">User Info</h6>
                            </div>
                            <input type="hidden" class="form-control" name="id" id="id" value="" />
                            <div class="col-md-3">
                                <label class="col-form-label">Full Name *</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" />
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">User Name *</label>
                                <input type="text" class="form-control" name="u_name" id="u_name"
                                       placeholder="Enter user name" />
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">Email *</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       placeholder="Enter email name" />
                            </div>
                            <div class="col-md-3">
                                <label class="col-12 col-form-label">Phone Number</label>

                                <input type="text" class="form-control" autocomplete="off" data-intl-tel-input-id="0" name="phone_number" id="phone_number"
                                       placeholder="Enter phone number" />
                            </div>
                            {{--                        <div class="col-md-4">--}}
                            {{--                            <label class="col-form-label">CNIC/Passport No</label>--}}
                            {{--                            <input type="text" class="form-control" name="cnic" id="cnic"--}}
                            {{--                                placeholder="Enter CNIC/Passport No" />--}}
                            {{--                        </div>--}}
                            <div class="col-md-4">
                                <label class="col-form-label">password</label>
                                <input type="password" class="form-control" name="password" id="password"
                                       placeholder="Enter password" />
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">Profile Photo</label>
                                <div class="input-group">
                                    <div class="custom-file">

                                        <input type="file" class="upload-image-site w-100" id="image1"
                                               name="profile" /><br />
                                        <div id="frames1"></div>
                                        <input type="hidden" name="old_image" id="old_image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <h6 class="text-dark">System Info</h6>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">Store *</label>
                                <select class="form-control selectpicker" name="store[]" id="store_id"
                                        data-live-search="true" data-actions-box="true" multiple="multiple">
                                    @if(!empty($stores))
                                        @foreach($stores as $obj)
                                            <option value="{{$obj->id}}">{{$obj->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">Role *</label>
                                <div class="input-group">
                                    <select class="form-control selectpicker" name="role_id" id="role_id"
                                            data-live-search="true">
                                        @if(!empty($roles))
                                            @foreach($roles as $obj)
                                                <option value="{{$obj->id}}">{{$obj->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary font-weight-bold" id="show_permission">
                                            <i class="la la-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">Type *</label>
                                <select class="form-control selectpicker" name="type" id="type" data-live-search="true">
                                    @if(!empty($types))
                                        @foreach($types as $value => $name)
                                            <option value="{{$value}}">{{$name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">Is Active *</label><br />
                                <span class="switch switch-outline switch-icon switch-success">
                                <label>
                                    <input type="checkbox" name="is_active" id="is_active" checked="checked" />
                                    <span></span>
                                </label>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold"
                                data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary font-weight-bold" id="btn_save">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--permission show modal-->
    <div class="modal fade" id="show_permission_modal" tabindex="-1" role="dialog" aria-labelledby="add_edit_modal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                    <span class="card-icon svg-icon svg-icon-primary svg-icon-2x">
                        <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Home\Key.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <polygon fill="#000000" opacity="0.3"
                                         transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) "
                                         points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476" />
                                <path
                                    d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z"
                                    fill="#000000"
                                    transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) " />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                        Permissions
                    </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body" id="show_permission_body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold" id="btn_save">Save</button>
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
        var table = "";
        var datatable = function() {
            var initTable = function() {
                // begin first table
                table = $('#datatableList').DataTable({
                    responsive: true,
                    // Pagination settings
                    dom: `<'row'<'col-sm-12'tr>> <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                    // read more: https://datatables.net/examples/basic_init/dom.html

                    lengthMenu: [5, 10, 25, 50],

                    pageLength: 10,

                    language: {
                        'lengthMenu': 'Display _MENU_',
                    },

                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('getCustomerList') }}",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'id','Store Name','email', 'name', 'Phone Number',
                                'created_at'
                            ],
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    columns: [
                        {
                            data: 'id'
                        },
                        {
                            data: 'Store Name'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'Phone Number'
                        },
                        {
                            data: 'action',
                            responsivePriority: -1,
                            bSortable: false
                        },
                    ],
                    order: [
                        [0, "desc"]
                    ]
                });

                var filter = function() {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                    table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
                };

                $('#kt_search').on('click', function(e) {
                    e.preventDefault();
                    var params = {};
                    $('.datatable-input').each(function() {
                        var i = $(this).data('col-index');
                        if (params[i]) {
                            params[i] += '|' + $(this).val();
                        } else {
                            params[i] = $(this).val();
                        }
                    });
                    $.each(params, function(i, val) {
                        // apply search params to datatable
                        table.column(i).search(val ? val : '', false, false);
                    });
                    table.table().draw();
                });

                $('#kt_reset').on('click', function(e) {
                    e.preventDefault();
                    $('.datatable-input').each(function() {
                        $(this).val('');
                        $('#store_id_search').val('').trigger('change')
                        table.column($(this).data('col-index')).search('', false, false);
                    });
                    table.table().draw();
                });

                $('#kt_datepicker').datepicker({
                    todayHighlight: true,
                    format: 'yyyy-mm-dd',
                    templates: {
                        leftArrow: '<i class="la la-angle-left"></i>',
                        rightArrow: '<i class="la la-angle-right"></i>',
                    },
                });

            };

            return {

                //main function to initiate the module
                init: function() {
                    initTable();
                },

            };

        }();

        jQuery(document).ready(function() {
            datatable.init();

            var validator = $("#addForm").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    u_name: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    name: {
                        required: true
                    },
                    role_id: {
                        required: true
                    },
                    type: {
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

            $('input[type="file"]').change(function(e) {
                var fileName = e.target.files[0].name;
                $(this).next('label.file_label').html(fileName);
            });

            $(document).on('click', '#btn_add_new', function() {
                $('#add_edit_modal').modal({
                    backdrop: 'static',
                    keyboard: false
                }).on('hide.bs.modal', function() {
                    validator.resetForm();
                });
                resetForm();
            });

            $(document).on('click', '#btn_save', function() {
                var validate = $("#addForm").valid();
                if (validate) {
                    //var form_data = $("#addForm").serializeArray();
                    var form = $('#addForm')[0];
                    var form_data = new FormData(form);
                    $.ajax({
                        type: "POST",
                        url: "{{route('userSubmit')}}", // your php file name
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
                                resetForm();
                                $('#add_edit_modal').modal('hide');
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
            });

            $(document).on('click', '.edit', function() {
                var id = $(this).data('id');
                var form_data = new FormData();
                form_data.append('id', id);
                $.ajax({
                    type: "POST",
                    url: "{{route('getUserById')}}", // your php file name
                    data: form_data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.status == 'success') {
                            $('#add_edit_modal').modal({
                                backdrop: 'static',
                                keyboard: false
                            }).on('hide.bs.modal', function() {
                                validator.resetForm();
                            });
                            var rec = data.data
                            console.log(rec);
                            var profile = data.imagePath;
                            var id = rec.id;
                            var name = rec.name;
                            // var username = rec.username;
                            var email = rec.email;
                            var phone_number = rec.phone_number;
                            var cnic = rec.cnic;
                            var role_id = rec.role_id;
                            $('#old_image').val(rec.photo);
                            //var path='';
                            // console.log(imagePath);
                            $('#frames1').html('<img src="' + profile +
                                '" style="margin-top:20px; text-align:center" width="50px" height="50px"/>'
                            );
                            var stores = data.stores;
                            var str_array = stores.split(',');
                            // console.log(str_array);
                            $("#store_id").val(str_array).trigger("change");

                            var photo = rec.photo;
                            var is_active = rec.is_active;
                            $('#id').val(id);

                            $('#email').val(email);
                            $('#u_name').val(rec.u_name);
                            $('#name').val(name);
                            $('#phone_number').val(phone_number);
                            $('#cnic').val(cnic);
                            $('#role_id').val(role_id).trigger('change');
                            $('#store').val(store_id).trigger('change');
                            $('#type').val(rec.type).trigger('change');

                            // $('#type').val(type).trigger('change');
                            //$('#dashboard').val(dashboard).trigger('change');
                            if (is_active == 1) {
                                $('#is_active').attr('checked', 'checked');
                            } else {
                                $('#is_active').removeAttr('checked');
                            }
                            // window.scrollTo({top: 0, behavior: 'smooth'});
                        } else {
                            Swal.fire("Sorry!", data.message, "error");
                        }
                    },
                    error: function(errorString) {
                        Swal.fire("Sorry!", "Something went wrong please contact to admin",
                            "error");
                    }
                });
            });

            $(document).on('click', '.delete', function() {
                var id = $(this).data('id');
                var form_data = new FormData();
                form_data.append('id', id);
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
                            url: "{{route('userDelete')}}", // your php file name
                            data: form_data,
                            dataType: "json",
                            processData: false,
                            contentType: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                if (data.status == 'success') {
                                    Swal.fire("Success!", data.message, "success");
                                    table.ajax.reload();
                                } else {
                                    Swal.fire("Sorry!", data.message, "error");
                                }
                            },
                            error: function(errorString) {
                                Swal.fire("Sorry!",
                                    "Something went wrong please contact to admin",
                                    "error");
                            }
                        });
                    }
                });
            });

            $(document).on('change', '#brand_id', function() {
                var ids = $(this).val();
                getBrandBranches(ids, 0);
            });

            $(document).on('click', '#show_permission', function() {
                var role_id = $('#role_id').val();
                if (role_id != "") {
                    var form_data = new FormData();
                    form_data.append('role_id', role_id);
                    $.ajax({
                        type: "POST",
                        url: "{{route('getPermissionByRoleId')}}", // your php file name
                        data: form_data,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                $('#show_permission_modal').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                });
                                $('#show_permission_body').html(data.html);
                            } else {
                                Swal.fire("Sorry!", data.message, "error");
                            }
                        },
                        error: function(errorString) {
                            Swal.fire("Sorry!", "Something went wrong please contact to admin",
                                "error");
                        }
                    });
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
                    toastr.info('Please select role first');
                }
            });


            var input = document.getElementById("addForm");
            input.addEventListener("keyup", function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                    document.getElementById("btn_save").click();
                }
            });



        });

        function resetForm() {
            $('#addForm')[0].reset();
            $('#id').val("");
            $('#brand_id').val("").trigger('change');
        }
        $(document).ready(function() {
            $('#image1').change(function() {
                $("#frames1").html('');
                for (var i = 0; i < $(this)[0].files.length; i++) {
                    $("#frames1").append('<img src="' + window.URL.createObjectURL(this.files[i]) +
                        '" style="margin-top:20px; text-align:center" width="50px" height="50px"/>');
                }
            });
        });
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

            $('#phone_number').mask(mask, {
                placeholder: maskNumber
            });
        });

    </script>
@endsection

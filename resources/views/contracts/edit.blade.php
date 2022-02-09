@extends('layouts.app')

@section('title', 'Contract')
@section('description', 'Contract')

@section('page_level_css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.4') }}" rel="stylesheet"
          type="text/css" />
    <link href="{{ asset('assets/plugins/custom/multiselect/multi-select.css?v=7.0.4') }}" rel="stylesheet"
          type="text/css" />
    <style>
        #addForm {
            width: 100%;
        }

        .ms-list {
            margin-top: 10px !important;
            margin-bottom: 10px !important;
        }

        .btn_multiselect_search_option {
            margin-top: 5px;
            width: 100%;
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
                <form onsubmit="return false" id="addForm">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span class="card-icon svg-icon svg-icon-primary svg-icon-2x">
                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Layout\Layout-grid.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="1">
                                        </rect>
                                        <path
                                            d="M5,10 L7,10 C7.55228475,10 8,10.4477153 8,11 L8,13 C8,13.5522847 7.55228475,14 7,14 L5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 L14,7 C14,7.55228475 13.5522847,8 13,8 L11,8 C10.4477153,8 10,7.55228475 10,7 L10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,13 C14,13.5522847 13.5522847,14 13,14 L11,14 C10.4477153,14 10,13.5522847 10,13 L10,11 C10,10.4477153 10.4477153,10 11,10 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,7 C20,7.55228475 19.5522847,8 19,8 L17,8 C16.4477153,8 16,7.55228475 16,7 L16,5 C16,4.44771525 16.4477153,4 17,4 Z M17,10 L19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 L17,14 C16.4477153,14 16,13.5522847 16,13 L16,11 C16,10.4477153 16.4477153,10 17,10 Z M5,16 L7,16 C7.55228475,16 8,16.4477153 8,17 L8,19 C8,19.5522847 7.55228475,20 7,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,17 C4,16.4477153 4.44771525,16 5,16 Z M11,16 L13,16 C13.5522847,16 14,16.4477153 14,17 L14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 L10,17 C10,16.4477153 10.4477153,16 11,16 Z M17,16 L19,16 C19.5522847,16 20,16.4477153 20,17 L20,19 C20,19.5522847 19.5522847,20 19,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,17 C16,16.4477153 16.4477153,16 17,16 Z"
                                            fill="#000000"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                                Contract
                            </span>
                        </h5>
                        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button> --}}
                    </div>
                    <div class="modal-body">
                        <input type="hidden" class="form-control" name="id" id="contract_id"
                               value="{{ !empty($contract->id) ? $contract->id : '' }}" />
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <h5 class="text-dark">Contract Info</h5>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">Contract Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name"
                                       placeholder="Enter contract name"
                                       value="{{ !empty($contract->name) ? $contract->name : '' }}" />
                            </div>

                            <div class="col-md-6">
                                <label class="col-form-label">Select Date range<span class="text-danger">*</span></label>
                                <input class="form-control" name="date_range"
                                       value="{{ !empty($contract->start_date) && $contract->end_date ? date('Y/m/d', strtotime($contract->start_date)) . ' ' . '-' . ' ' . date('Y/m/d', strtotime($contract->end_date)) : '' }}"
                                       id="date_range" readonly="readonly" placeholder="Select Date" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="exampleTextarea">Notes</label>
                                <textarea class="form-control" id="notes" name="notes"
                                          rows="3">{{ !empty($contract->note) ? $contract->note : '' }}</textarea>
                            </div>
                        </div>
                        {{--<div class="row">
                            <div class="col-md-4">
                                <label class="col-form-label">Is Active *</label><br>
                                <span class="switch switch-outline switch-icon switch-success">
                                    <label>
                                        <input type="checkbox" name="is_active" id="is_active" checked="checked">
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>--}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary font-weight-bold" id="btn_save">Save</button>
                        <a href="{{route('contractList')}}" class="btn btn-light-primary font-weight-bold"
                           data-dismiss="modal">Cancel</a>
                    </div>
                </form>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <!--begin::Entry-->
            <div class="d-flex flex-column-fluid">
                <!--begin::Container-->
                <div class="container">
                    <!--begin::Card-->
                    <div class="card card-custom">

                        <div class="card-body">
                            <!--begin: Search Form-->
                            <form class="kt-form kt-form--fit">
                                <div class="row mb-6">
                                    <div class="col-lg-3 mb-lg-0 mb-2">
                                        <label>Name:</label>
                                        <input type="text" class="form-control datatable-input" placeholder="E.g: test" data-col-index="1" />
                                    </div>
                                    <div class="col-lg-3 mb-lg-0 mb-2">
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
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Discount %</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Sr</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Discount %</th>
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


    </div>

@endsection

@section('page_level_js_plugins')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
    <script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4') }}"></script>
@endsection

@section('page_level_js')

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
        var contractID = $('#contract_id').val();
        var datatable = function() {
            var initTable = function() {
                // begin first table
                table = $('#datatableList').DataTable({
                    responsive: true,
                    // Pagination settings
                    dom: `<'row'<'col-sm-12'tr>> <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                    // read more: https://datatables.net/examples/basic_init/dom.html

                    lengthMenu: [5, 10, 25, 50],

                    pageLength: 200,

                    language: {
                        'lengthMenu': 'Display _MENU_',
                    },

                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('contractAssignedList',['id' => (!empty($contract->id) ? $contract->id : '')]) }}",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'Sr', 'Name','Category','Discount'
                            ],
                            "category_type" : "{{ Request::segment(2) }}",
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    columns: [
                        {data: 'Sr'},
                        {data: 'Name'},
                        {data: 'Category'},
                        {data: 'Discount'},
                        {data: 'action', responsivePriority: -1, bSortable: false},
                    ],
                    order: [
                        [1, "desc"]
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
            @if (!empty($productIds))
            // let arr = $productIds;
            // let obj = arr.reduce((ac,a) => ({...ac,[a]:''}),{});
            // console.log(obj);
             @endif

            datatable.init();
            var validator = $("#addForm").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    name: {
                        required: true
                    },
                    contract_type: {
                        required: true
                    },
                    date_range: {
                        required: true
                    }



                },

                errorPlacement: function(error, element) {
                    var elem = $(element);
                    if (elem.hasClass("contract_price") || elem.hasClass("category_id") || elem
                        .hasClass("value")) {
                        element = elem.parent();
                        error.insertAfter(element);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });

            $('.selectpicker').selectpicker().change(function() {
                $(this).valid()
            });




            $(document).on('click', '#btn_save', function() {
                var type = $('#contract_type').val();
                var validate = $("#addForm").valid();
                if (validate) {
                    var form_data = $("#addForm").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('contractUpdate') }}", // your php file name
                        data: form_data,
                        dataType: "json",
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
                                setTimeout(function() {
                                    window.location = "{{ route('contractList') }}";
                                }, 3000);
                            } else {
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
            $(document).on('click','.delete',function() {
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
                            url: "{{route('contractRemove')}}", // your php file name
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
                                    table.ajax.reload();
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
            });
            $(document).on('click','.save',function() {
                var id = $(this).data('id');
                var info=id.split("~");
                var product_id=info[0];
                var mapping_id=info[1];
                var discount_price=$('#contract_price_'+product_id).val();
                var contract_id=$('#contract_id').val();
                if(discount_price!='' && discount_price <=100){

                    var form_data = new FormData();
                    form_data.append('product_id', product_id);
                    form_data.append('mapping_id', mapping_id);
                    form_data.append('discount', discount_price);
                    form_data.append('contract_id', contract_id);
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You wont to update this product contract price!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, update it!"
                    }).then(function(result) {
                        if (result.value) {
                            $.ajax({
                                type: "POST",
                                url: "{{route('contractSaved')}}", // your php file name
                                data: form_data,
                                dataType: "json",
                                processData: false,
                                contentType: false,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (data){
                                    if(data.status == 'success') {
                                        $('#contract_price_error_'+product_id).html('');
                                        Swal.fire("Success!", data.message, "success");
                                        table.ajax.reload();
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
                else{

                    $('#contract_price_error_'+product_id).html('please fill out the accurate discount price');
                    $('#contract_price_'+product_id).val('');
                }
            });




        });

        function resetForm() {
            $('#addForm')[0].reset();
            $('#id').val("");
        }
        $('#date_range').daterangepicker({
            locale: {
                format: 'YYYY/MM/DD'
            },
        });







    </script>
@endsection

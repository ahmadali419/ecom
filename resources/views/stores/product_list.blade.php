@extends('layouts.app')

@section('title', 'Product')
@section('description', 'Product')

@section('page_level_css')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
    <style>
        #addForm {
            width: 100%;
        }
        select.select2 {
            opacity: 1 !important;
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
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <span class="card-icon svg-icon svg-icon-primary svg-icon-2x">
                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Layout\Layout-grid.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="1"></rect>
                                        <path d="M5,10 L7,10 C7.55228475,10 8,10.4477153 8,11 L8,13 C8,13.5522847 7.55228475,14 7,14 L5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 L14,7 C14,7.55228475 13.5522847,8 13,8 L11,8 C10.4477153,8 10,7.55228475 10,7 L10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,13 C14,13.5522847 13.5522847,14 13,14 L11,14 C10.4477153,14 10,13.5522847 10,13 L10,11 C10,10.4477153 10.4477153,10 11,10 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,7 C20,7.55228475 19.5522847,8 19,8 L17,8 C16.4477153,8 16,7.55228475 16,7 L16,5 C16,4.44771525 16.4477153,4 17,4 Z M17,10 L19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 L17,14 C16.4477153,14 16,13.5522847 16,13 L16,11 C16,10.4477153 16.4477153,10 17,10 Z M5,16 L7,16 C7.55228475,16 8,16.4477153 8,17 L8,19 C8,19.5522847 7.55228475,20 7,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,17 C4,16.4477153 4.44771525,16 5,16 Z M11,16 L13,16 C13.5522847,16 14,16.4477153 14,17 L14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 L10,17 C10,16.4477153 10.4477153,16 11,16 Z M17,16 L19,16 C19.5522847,16 20,16.4477153 20,17 L20,19 C20,19.5522847 19.5522847,20 19,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,17 C16,16.4477153 16.4477153,16 17,16 Z" fill="#000000"></path>
                                    </g>
                                </svg><!--end::Svg Icon-->
                            </span>
                            <h3 class="card-label">Products List</h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Dropdown-->
                            <div class="dropdown dropdown-inline mr-2"></div>
                            <!--end::Dropdown-->
                            <!--begin::Button-->
                            <a href="{{ route('storeProductPricing') }}" class="btn btn-primary font-weight-bolder" id="btn_add_new">
                            <span class="svg-icon svg-icon-md">
                               <!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo5/dist/../src/media/svg/icons/Shopping/Pound.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M7.825,10.225 C7.2,9.475 6.85,8.4 6.85,7.375 C6.85,4.55 9.15,2.05 12.35,2.05 C15.45,2.05 17.8,4.45 17.875,7.425 L15.075,7.425 C15.075,5.85 13.975,4.6 12.35,4.6 C10.75,4.6 9.6,5.775 9.6,7.375 C9.6,8.26626781 10.0162926,9.06146809 10.6676674,9.58392078 C10.7130614,9.62033024 10.7238389,12.2340233 10.7,17.425 L17.5444449,17.425 C17.8205873,17.425 18.0444449,17.6488576 18.0444449,17.925 C18.0444449,17.9869142 18.0329457,18.0482899 18.0105321,18.1060047 L17.3988817,19.6810047 C17.3242018,19.8733052 17.1390868,20 16.9327944,20 L6.3,20 C6.02385763,20 5.8,19.7761424 5.8,19.5 L5.8,17.925 C5.8,17.6488576 6.02385763,17.425 6.3,17.425 L7.925,17.425 L7.925,12.475 L7.825,10.225 Z" fill="#000000"/>
                                        <path d="M4.3618034,11.2763932 L4.8618034,10.2763932 C4.94649941,10.1070012 5.11963097,10 5.30901699,10 L15.190983,10 C15.4671254,10 15.690983,10.2238576 15.690983,10.5 C15.690983,10.5776225 15.6729105,10.6541791 15.6381966,10.7236068 L15.1381966,11.7236068 C15.0535006,11.8929988 14.880369,12 14.690983,12 L4.80901699,12 C4.53287462,12 4.30901699,11.7761424 4.30901699,11.5 C4.30901699,11.4223775 4.32708954,11.3458209 4.3618034,11.2763932 Z" fill="#000000" opacity="0.3"/>
                                    </g>
                                </svg><!--end::Svg Icon-->
                            </span>Product Pricing</a>
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Search Form-->
                        <form class="kt-form kt-form--fit">
                            <div class="row mb-6">
                                <div class="col-lg-3 mb-lg-3 mb-2">
                                    <div class="form-group">
                                        <div class="w-100">
                                            <label for="exampleSelectd">Store<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="w-100">
                                            <select class="form-control select2 kt-select2-general categories  datatable-input" id="store_id"  data-col-index="3" >
                                                <option value="" selected>Select Store</option>
                                                @foreach($allstores as $store)
                                                    <option value="{{$store->id}}">{{$store->name}}</option>
                                                @endforeach;

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 mb-lg-0 mb-2">
                                    <label>Name:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="E.g: product name" data-col-index="1" />
                                </div>
                                <div class="col-lg-3 mb-lg-0 mb-2">
                                    <label>Category:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="E.g: category name" data-col-index="2" />
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
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Discount % </th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Sr</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Discount % </th>
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
    <div class="modal fade" id="product_pricing_model" tabindex="-1" role="dialog" aria-labelledby="product_pricing_model" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="card-icon svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Layout\Layout-grid.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="1"></rect>
                                    <path d="M5,10 L7,10 C7.55228475,10 8,10.4477153 8,11 L8,13 C8,13.5522847 7.55228475,14 7,14 L5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 L14,7 C14,7.55228475 13.5522847,8 13,8 L11,8 C10.4477153,8 10,7.55228475 10,7 L10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,13 C14,13.5522847 13.5522847,14 13,14 L11,14 C10.4477153,14 10,13.5522847 10,13 L10,11 C10,10.4477153 10.4477153,10 11,10 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,7 C20,7.55228475 19.5522847,8 19,8 L17,8 C16.4477153,8 16,7.55228475 16,7 L16,5 C16,4.44771525 16.4477153,4 17,4 Z M17,10 L19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 L17,14 C16.4477153,14 16,13.5522847 16,13 L16,11 C16,10.4477153 16.4477153,10 17,10 Z M5,16 L7,16 C7.55228475,16 8,16.4477153 8,17 L8,19 C8,19.5522847 7.55228475,20 7,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,17 C4,16.4477153 4.44771525,16 5,16 Z M11,16 L13,16 C13.5522847,16 14,16.4477153 14,17 L14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 L10,17 C10,16.4477153 10.4477153,16 11,16 Z M17,16 L19,16 C19.5522847,16 20,16.4477153 20,17 L20,19 C20,19.5522847 19.5522847,20 19,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,17 C16,16.4477153 16.4477153,16 17,16 Z" fill="#000000"></path>
                                </g>
                            </svg><!--end::Svg Icon-->
                            Product Price
                        </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body" id="product_pricing"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_level_js_plugins')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
    <script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.4')}}"></script>
    <script src="{{ asset ('assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4') }}"></script>
@endsection

@section('page_level_js')
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

                        url: "{{ route('storeProductList') }}",

                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'Sr', 'Name', 'Category' ,'Discount % '
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
                        {data: 'Discount % '},
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
                        $('#store_id').val('').trigger('change')
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
                            url: "{{route('productDelete')}}", // your php file name
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

        });

        function resetForm() {
            $('#addForm')[0].reset();
            $('#id').val("");
        }

        $(document).on('click','.show_pricing',function() {
            var store_id = $(this).data('store_id');
            var product_id = $(this).data('product_id');
            loadPricingModel(store_id, product_id);
        });

        $(document).on('click','#btn_save_single_product_pricing',function() {
            var form_data = new FormData($('#single_product_pricing_form')[0]);
            $.ajax({
                type: "POST",
                url: "{{route('updateStoreSingleProductPrice')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data){
                    if(data.status == 'success') {
                        var store_id = data.store_id;
                        var product_id = data.product_id;
                        loadPricingModel(store_id, product_id);
                    }
                },
                error: function (errorString){
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });
        });

        function loadPricingModel(store_id, product_id) {
            var form_data = new FormData();
            form_data.append('store_id', store_id);
            form_data.append('id', product_id);
            form_data.append('store_id', store_id);
            $.ajax({
                type: "POST",
                url: "{{route('getStoreProductPrice')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data){
                    $('#product_pricing_model').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#product_pricing').html('');
                    $('#product_pricing').html(data.html);
                },
                error: function (errorString){
                    Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                }
            });
        }

        function addNew() {
            var number = 1;
            var  newfilds = `
                <div class="row mb-2 test_${number}">
                    <div class="form-group col-lg-6 col-md-6 col-6">
                        <label class="col-form-label">Charges Type<span class="text-danger">*</span></label>
                        <div class="w-100">
                        <select class="form-control select2 kt-select2-general categories "  id="charge_id" name="charge_id[]" required>
                               <option value="" selected>Charges Type</option>
                                @foreach($charges as $obj)
                                     <option value="{{$obj->id}}">{{$obj->name}}</option>
                                    @endforeach
                        </select>
                    </div>
                </div>
            <div class="form-group col-lg-4 col-md-4 col-4">
                <label class="col-form-label">Charge Name<span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="charge_value" id="charge_value" placeholder="Enter role name" />
            </div>
                <div class="col-form-label form-group col-lg-2 col-md-2 col-2">
                    <button class="btn btn-primary  font-weight-bold mt-8" type="button" onclick="remove(${number})">-</button>

                </div>
            </div>
        `;
            $('#product_pricing').append(newfilds);
        }
        function removedb(id) {
            //alert(id);
            $('.testdb_' + id).remove();
        }


        $(document).on('click', '#btn_save', function(){
            var validate = $("#addForm").valid();
            if(validate) {
                var form_data = $("#addForm").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{route('storeproductpricesubmit')}}", // your php file name
                    data: form_data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
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
                            $('#product_pricing_model').modal('hide');
                            table.ajax.reload();
                        } else {
                            Swal.fire("Sorry!", data.message, "error");
                        }
                    },
                    error: function (errorString) {
                        Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                    }
                });
            }
        });




    </script>
@endsection

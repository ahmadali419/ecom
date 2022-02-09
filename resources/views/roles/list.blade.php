@extends('layouts.app')

@section('title', 'Role')

@section('page_level_css_plugins')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page_level_css')
    <style type="text/css">
        #addForm {
            width: 100%;
        }
        .select2-container{
            width: 100% !important;
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
                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Design\Arrows.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M10.4289322,12.3786797 L5.30761184,7.25735931 C4.91708755,6.86683502 4.91708755,6.23367004 5.30761184,5.84314575 C5.69813614,5.45262146 6.33130112,5.45262146 6.72182541,5.84314575 L11.8431458,10.9644661 L18.0355339,4.77207794 C18.4260582,4.38155365 19.0592232,4.38155365 19.4497475,4.77207794 C19.8402718,5.16260223 19.8402718,5.79576721 19.4497475,6.1862915 L13.2573593,12.3786797 L19.4497475,18.5710678 C19.8402718,18.9615921 19.8402718,19.5947571 19.4497475,19.9852814 C19.0592232,20.3758057 18.4260582,20.3758057 18.0355339,19.9852814 L11.8431458,13.7928932 L6.72182541,18.9142136 C6.33130112,19.3047379 5.69813614,19.3047379 5.30761184,18.9142136 C4.91708755,18.5236893 4.91708755,17.8905243 5.30761184,17.5 L10.4289322,12.3786797 Z" fill="#000000" opacity="0.3" transform="translate(12.378680, 12.378680) rotate(-315.000000) translate(-12.378680, -12.378680) "/>
                                        <path d="M3.51471863,12 L5.63603897,14.1213203 C6.02656326,14.6736051 6.02656326,15.1450096 5.63603897,15.5355339 C5.24551468,15.9260582 4.77411016,15.9260582 4.22182541,15.5355339 L0.686291501,12 L4.22182541,8.46446609 C4.69322993,7.99306157 5.16463445,7.99306157 5.63603897,8.46446609 C6.10744349,8.93587061 6.10744349,9.40727514 5.63603897,9.87867966 L3.51471863,12 Z M12,20.4852814 L14.1213203,18.363961 C14.6736051,17.9734367 15.1450096,17.9734367 15.5355339,18.363961 C15.9260582,18.7544853 15.9260582,19.2258898 15.5355339,19.7781746 L12,23.3137085 L8.46446609,19.7781746 C7.99306157,19.3067701 7.99306157,18.8353656 8.46446609,18.363961 C8.93587061,17.8925565 9.40727514,17.8925565 9.87867966,18.363961 L12,20.4852814 Z M20.4852814,12 L18.363961,9.87867966 C17.9734367,9.32639491 17.9734367,8.85499039 18.363961,8.46446609 C18.7544853,8.0739418 19.2258898,8.0739418 19.7781746,8.46446609 L23.3137085,12 L19.7781746,15.5355339 C19.3067701,16.0069384 18.8353656,16.0069384 18.363961,15.5355339 C17.8925565,15.0641294 17.8925565,14.5927249 18.363961,14.1213203 L20.4852814,12 Z M12,3.51471863 L9.87867966,5.63603897 C9.32639491,6.02656326 8.85499039,6.02656326 8.46446609,5.63603897 C8.0739418,5.24551468 8.0739418,4.77411016 8.46446609,4.22182541 L12,0.686291501 L15.5355339,4.22182541 C16.0069384,4.69322993 16.0069384,5.16463445 15.5355339,5.63603897 C15.0641294,6.10744349 14.5927249,6.10744349 14.1213203,5.63603897 L12,3.51471863 Z" fill="#000000" fill-rule="nonzero"/>
                                    </g>
                                </svg><!--end::Svg Icon-->
                            </span>
                            <h3 class="card-label">Role List</h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Dropdown-->
                            <div class="dropdown dropdown-inline mr-2"></div>
                            <!--end::Dropdown-->
                             @if(hasPermission('addRole'))
                            <!--begin::Button-->
                                <a href="javascript:;" class="btn btn-primary font-weight-bolder" id="btn_add_new">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Code\Plus.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                            <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
                                        </g>
                                    </svg><!--end::Svg Icon-->
                                </span>Add Role</a>
                                <!--end::Button-->
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Search Form-->
                        <form class="kt-form kt-form--fit">
                            <div class="row mb-6">
                                <div class="col-lg-3 mb-lg-2 mb-2">
                                    <label>Role:</label>
                                    <input type="text" class="form-control datatable-input" placeholder="E.g: test" data-col-index="1" />
                                </div>
                                <div class="col-lg-9 mb-lg-2 mb-2">
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
                                <th>Record ID</th>
                                <th>Role Name</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Record ID</th>
                                <th>Role Name</th>
                                <th>Created</th>
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
    <div class="modal fade" id="add_edit_modal" tabindex="-1" role="dialog" aria-labelledby="add_edit_modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
            <form onsubmit="return false" id="addForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span class="card-icon svg-icon svg-icon-primary svg-icon-2x">
                               <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Design\Arrows.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M10.4289322,12.3786797 L5.30761184,7.25735931 C4.91708755,6.86683502 4.91708755,6.23367004 5.30761184,5.84314575 C5.69813614,5.45262146 6.33130112,5.45262146 6.72182541,5.84314575 L11.8431458,10.9644661 L18.0355339,4.77207794 C18.4260582,4.38155365 19.0592232,4.38155365 19.4497475,4.77207794 C19.8402718,5.16260223 19.8402718,5.79576721 19.4497475,6.1862915 L13.2573593,12.3786797 L19.4497475,18.5710678 C19.8402718,18.9615921 19.8402718,19.5947571 19.4497475,19.9852814 C19.0592232,20.3758057 18.4260582,20.3758057 18.0355339,19.9852814 L11.8431458,13.7928932 L6.72182541,18.9142136 C6.33130112,19.3047379 5.69813614,19.3047379 5.30761184,18.9142136 C4.91708755,18.5236893 4.91708755,17.8905243 5.30761184,17.5 L10.4289322,12.3786797 Z" fill="#000000" opacity="0.3" transform="translate(12.378680, 12.378680) rotate(-315.000000) translate(-12.378680, -12.378680) "/>
                                        <path d="M3.51471863,12 L5.63603897,14.1213203 C6.02656326,14.6736051 6.02656326,15.1450096 5.63603897,15.5355339 C5.24551468,15.9260582 4.77411016,15.9260582 4.22182541,15.5355339 L0.686291501,12 L4.22182541,8.46446609 C4.69322993,7.99306157 5.16463445,7.99306157 5.63603897,8.46446609 C6.10744349,8.93587061 6.10744349,9.40727514 5.63603897,9.87867966 L3.51471863,12 Z M12,20.4852814 L14.1213203,18.363961 C14.6736051,17.9734367 15.1450096,17.9734367 15.5355339,18.363961 C15.9260582,18.7544853 15.9260582,19.2258898 15.5355339,19.7781746 L12,23.3137085 L8.46446609,19.7781746 C7.99306157,19.3067701 7.99306157,18.8353656 8.46446609,18.363961 C8.93587061,17.8925565 9.40727514,17.8925565 9.87867966,18.363961 L12,20.4852814 Z M20.4852814,12 L18.363961,9.87867966 C17.9734367,9.32639491 17.9734367,8.85499039 18.363961,8.46446609 C18.7544853,8.0739418 19.2258898,8.0739418 19.7781746,8.46446609 L23.3137085,12 L19.7781746,15.5355339 C19.3067701,16.0069384 18.8353656,16.0069384 18.363961,15.5355339 C17.8925565,15.0641294 17.8925565,14.5927249 18.363961,14.1213203 L20.4852814,12 Z M12,3.51471863 L9.87867966,5.63603897 C9.32639491,6.02656326 8.85499039,6.02656326 8.46446609,5.63603897 C8.0739418,5.24551468 8.0739418,4.77411016 8.46446609,4.22182541 L12,0.686291501 L15.5355339,4.22182541 C16.0069384,4.69322993 16.0069384,5.16463445 15.5355339,5.63603897 C15.0641294,6.10744349 14.5927249,6.10744349 14.1213203,5.63603897 L12,3.51471863 Z" fill="#000000" fill-rule="nonzero"/>
                                    </g>
                                </svg><!--end::Svg Icon-->
                                Role
                            </span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    @php $totalstores=count($stores);@endphp
                    <div class="modal-body">
                        <div class="row mb-2">
                            <input type="hidden" class="form-control" name="id" id="id" value="" />
                            <div class="col-md-12">
                                <h6 class="text-dark">Role Info</h6>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">Role Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"  name="name" id="name" placeholder="Enter role name" />
                            </div>
                            @if(!empty($stores))
                            <div class="form-group col-lg-6 col-md-6 col-6">
                                <label class="col-form-label">Select Store</label>
                                <div class="w-100">
                                    <select class="form-control select2 kt-select2-custom categories "  id="store_id" name="store_id" @if($totalstores=='1' && Auth::user()->type!='super_admin') {{'readonly'}}@endif >
                                        <option value="" >Select Store</option>
                                        @foreach($stores as $obj)
                                            @if($totalstores==1 && Auth::user()->type!='super_admin')
                                                <option value="{{$obj->id}}" {{'selected'}}>{{$obj->name}}</option>
                                            @else
                                                <option value="{{$obj->id}}">{{$obj->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary font-weight-bold" id="btn_save" >Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="assign_permission_modal" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign Permission</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="assign_permission_form">
                        <div class="row" id="assign_permission_html"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold" id="assign_permission_to_role">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_level_js_plugins')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
    <script src="{{ asset ('assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4') }}"></script>
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
                        url: "{{ route('getRoleList') }}",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'id', 'name', 'created_at'
                            ],
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    columns: [
                        {data: 'id'},
                        {data: 'name'},
                        {data: 'created_at'},
                        {data: 'action', responsivePriority: -1, bSortable: false},
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
                    name: {
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

            // $('.selectpicker').selectpicker().change(function(){
            //     $(this).valid()
            // });

            $(document).on('click', '#btn_add_new', function(){
                $('#add_edit_modal').modal({
                    backdrop: 'static',
                    keyboard: false
                }).on('hide.bs.modal', function(){
                    validator.resetForm();
                });
                resetForm();
            });

            $(document).on('click', '#btn_save', function(){
                var validate = $("#addForm").valid();
                if(validate) {
                    var form_data = $("#addForm").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: "{{route('roleSubmit')}}", // your php file name
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
                                $('#add_edit_modal').modal('hide');
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

            $(document).on('click','.edit',function() {
                var id = $(this).data('id');
                var form_data = new FormData();
                form_data.append('id', id);
                $.ajax({
                    type: "POST",
                    url: "{{route('getRoleById')}}", // your php file name
                    data: form_data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data){
                        if(data.status == 'success') {
                            $('#add_edit_modal').modal({
                                backdrop: 'static',
                                keyboard: false
                            }).on('hide.bs.modal', function(){
                                validator.resetForm();
                            });
                            var rec = data.data;
                            var id = rec.id;
                            var name = rec.name;
                            var store_id = rec.store_id;
                            $('#id').val(id);
                            $('#name').val(name);
                            $('#store_id').val(store_id).trigger('change');
                           window.scrollTo({top: 0, behavior: 'smooth'});
                        } else {
                            Swal.fire("Sorry!", data.message, "error");
                        }
                    },
                    error: function (errorString){
                        Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                    }
                });
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
                            url: "{{route('roleDelete')}}", // your php file name
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

            $(document).on('click','.assign_permission',function() {
                var id = $(this).data('id');
                var form_data = new FormData();
                form_data.append('role_id', id);
                $.ajax({
                    type: "POST",
                    url: "{{route('rolePermissions')}}", // your php file name
                    data: form_data,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data){
                        if(data.status == 'success') {
                            var rec = data.data;
                            $('#assign_permission_html').html(rec);
                            $('#assign_permission_modal').modal({
                                backdrop: 'static',
                                keyboard: false
                            });
                        } else {
                            Swal.fire("Sorry!", data.message, "error");
                        }
                    },
                    error: function (errorString){
                        Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                    }
                });
            });

            {{--$(document).on('click','#assign_permission_to_role',function() {--}}
            {{--    var id = $(this).data('id');--}}
            {{--    var form_data = new FormData();--}}
            {{--    form_data.append('role_id', id);--}}
            {{--    $.ajax({--}}
            {{--        type: "POST",--}}
            {{--        url: "{{route('rolePermissions')}}", // your php file name--}}
            {{--        data: form_data,--}}
            {{--        dataType: "json",--}}
            {{--        processData: false,--}}
            {{--        contentType: false,--}}
            {{--        headers: {--}}
            {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
            {{--        },--}}
            {{--        success: function (data){--}}
            {{--            if(data.status == 'success') {--}}
            {{--                var rec = data.data;--}}
            {{--                $('#assign_permission_html').html(rec);--}}
            {{--                $('#assign_permission_modal').modal({--}}
            {{--                    backdrop: 'static',--}}
            {{--                    keyboard: false--}}
            {{--                });--}}
            {{--            } else {--}}
            {{--                Swal.fire("Sorry!", data.message, "error");--}}
            {{--            }--}}
            {{--        },--}}
            {{--        error: function (errorString){--}}
            {{--            Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");--}}
            {{--        }--}}
            {{--    });--}}
            {{--});--}}

            $(document).on('click','#assign_permission_to_role',function() {
                var form_data = $("#assign_permission_form").serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{route('assignPermissions')}}", // your php file name
                    data: form_data,
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data){
                        if(data.status == 'success') {
                            $('#assign_permission_modal').modal('hide');
                            Swal.fire("Success!", data.message, "success");
                        } else {
                            Swal.fire("Sorry!", data.message, "error");
                        }
                    },
                    error: function (errorString){
                        Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
                    }
                });
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
        }
    </script>
@endsection

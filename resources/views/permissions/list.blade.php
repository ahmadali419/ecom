@extends('layouts.app')

@section('title', 'Permission')

@section('page_level_css_plugins')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page_level_css')
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
            @if(hasPermission('viewPermission') &&  hasPermission('addPermission'))
                <!--begin::Card-->
                    <div class="card card-custom mb-10">
                        <div class="card-header">
                            <div class="card-title">
                            <span class="card-icon svg-icon svg-icon-primary svg-icon-2x">
                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Home\Key.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <polygon fill="#000000" opacity="0.3" transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) " points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476"/>
                                        <path d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z" fill="#000000" transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) "/>
                                    </g>
                                </svg><!--end::Svg Icon-->
                            </span>
                                <h3 class="card-label">Permission Add</h3>
                            </div>
                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                <div class="dropdown dropdown-inline mr-2"></div>
                                <!--end::Dropdown-->
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" id="addForm">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="id" id="id" value="" />
                                    <div class="col-md-4">
                                        <label class="col-form-label">Permission Category *</label>
                                        <select class="form-control selectpicker datatable-input" name="category_id" id="category_id" data-live-search="true">
                                            <option value="">Select</option>
                                            @if(!empty($categories))
                                                @foreach($categories as $obj)
                                                    <option value="{{$obj->id}}">{{$obj->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-form-label">Permission Name *</label>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter category name" />
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-md-12 text-right">
                                        <button type="button" class="btn btn-primary font-weight-bold" id="btn_save" >Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--begin::Card-->
                    <!--begin::Card-->
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                            <span class="card-icon svg-icon svg-icon-primary svg-icon-2x">
                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Home\Key.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <polygon fill="#000000" opacity="0.3" transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) " points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476"/>
                                        <path d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z" fill="#000000" transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) "/>
                                    </g>
                                </svg><!--end::Svg Icon-->
                            </span>
                                <h3 class="card-label">Permission List</h3>
                            </div>
                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                <div class="dropdown dropdown-inline mr-2"></div>
                                <!--end::Dropdown-->
                            </div>
                        </div>
                        <div class="card-body">
                            <!--begin: Search Form-->
                            <form class="kt-form kt-form--fit mb-15">
                                <div class="row mb-6">
                                    {{-- <div class="col-lg-3 mb-lg-0 mb-6">
                                        <label>RecordID:</label>
                                        <input type="text" class="form-control datatable-input" placeholder="E.g: 4590" data-col-index="0" />
                                    </div> --}}
                                    <div class="col-lg-3 mb-lg-0 mb-6">
                                        <label>Permission Category:</label>
                                        <select class="form-control selectpicker datatable-input" data-live-search="true" data-col-index="1">
                                            <option value="">Select</option>
                                            @if(!empty($categories))
                                                @foreach($categories as $obj)
                                                    <option value="{{$obj->id}}">{{$obj->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-3 mb-lg-0 mb-6">
                                        <label>Permission:</label>
                                        <input type="text" class="form-control datatable-input" placeholder="E.g: test" data-col-index="2" />
                                    </div>
                                    <div class="col-lg-3 mb-lg-0 mb-6">
                                        <label>Created Date:</label>
                                        <div class="input-daterange input-group" id="kt_datepicker">
                                            <input type="text" class="form-control datatable-input" placeholder="From" data-col-index="3" />
                                            <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-ellipsis-h"></i>
                                            </span>
                                            </div>
                                            <input type="text" class="form-control datatable-input" placeholder="To" data-col-index="3" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-8">
                                    <div class="col-lg-12">
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
                                    <th>Permission Category</th>
                                    <th>Permission</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Record ID</th>
                                    <th>Permission Category</th>
                                    <th>Permission</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                                </tfoot>
                            </table>
                            <!--end: Datatable-->
                        </div>
                    </div>
                    <!--end::Card-->
                @else
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                        <span class="card-icon svg-icon svg-icon-primary svg-icon-2x">
                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Home\Key.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <polygon fill="#000000" opacity="0.3" transform="translate(8.885842, 16.114158) rotate(-315.000000) translate(-8.885842, -16.114158) " points="6.89784488 10.6187476 6.76452164 19.4882481 8.88584198 21.6095684 11.0071623 19.4882481 9.59294876 18.0740345 10.9659914 16.7009919 9.55177787 15.2867783 11.0071623 13.8313939 10.8837471 10.6187476"/>
                                    <path d="M15.9852814,14.9852814 C12.6715729,14.9852814 9.98528137,12.2989899 9.98528137,8.98528137 C9.98528137,5.67157288 12.6715729,2.98528137 15.9852814,2.98528137 C19.2989899,2.98528137 21.9852814,5.67157288 21.9852814,8.98528137 C21.9852814,12.2989899 19.2989899,14.9852814 15.9852814,14.9852814 Z M16.1776695,9.07106781 C17.0060967,9.07106781 17.6776695,8.39949494 17.6776695,7.57106781 C17.6776695,6.74264069 17.0060967,6.07106781 16.1776695,6.07106781 C15.3492424,6.07106781 14.6776695,6.74264069 14.6776695,7.57106781 C14.6776695,8.39949494 15.3492424,9.07106781 16.1776695,9.07106781 Z" fill="#000000" transform="translate(15.985281, 8.985281) rotate(-315.000000) translate(-15.985281, -8.985281) "/>
                                </g>
                            </svg><!--end::Svg Icon-->
                        </span>
                                <h3 class="card-label">Permissions</h3>
                            </div>
                            <div class="card-toolbar">
                                <!--begin::Dropdown-->
                                <div class="dropdown dropdown-inline mr-2"></div>
                                <!--end::Dropdown-->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="alert alert-danger">You donot have permission to access this panel</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection

@section('page_level_js_plugins')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
@endsection

@section('page_level_js')
    <script type="text/javascript">
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
                        url: "{{ route('getPermissionList') }}",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'id', 'category_id', 'name', 'created_at'
                            ],
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    },
                    columns: [
                        {data: 'id'},
                        {data: 'category_id'},
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

            $("#addForm").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    name: {
                        required: true
                    },
                    category_id: {
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

            $('.selectpicker').selectpicker().change(function(){
                $(this).valid()
            });

            $(document).on('click', '#btn_save', function(){
                var validate = $("#addForm").valid();
                if(validate) {
                    var form_data = $("#addForm").serializeArray();
                    $.ajax({
                        type: "POST",
                        url: "{{route('permissionSubmit')}}", // your php file name
                        data: form_data,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data.status == 'success') {
                                Swal.fire("Success!", data.message, "success");
                                $('#addForm')[0].reset();
                                $('#id').val("");
                                $('#category_id').val("");
                                $('#category_id').selectpicker('refresh');
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
                    url: "{{route('getPermissionById')}}", // your php file name
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
                            var id = rec.id;
                            var category_id = rec.category_id;
                            var name = rec.name;
                            $('#id').val(id);
                            $('#category_id').val(category_id);
                            $('#category_id').selectpicker('refresh');
                            $('#name').val(name);
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
                            url: "{{route('permissionDelete')}}", // your php file name
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
    </script>
@endsection

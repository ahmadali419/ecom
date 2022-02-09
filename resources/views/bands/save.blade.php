@extends('layouts.app')

@section('title', 'New Band')
@section('description', 'New Band')

@section('page_level_css')
    <style>
        #tbl_custom_price tr td {
            width: 60px;
            height: 20px;
        }

        #tbl_custom_price {
            border: none;
        }

        #tbl_custom_price tr td:last-child {
            border: none;
        }

        #tbl_custom_price tr:first-child td {
            border: none;
        }

        #tbl_custom_price tr td button {
            padding: 0.10rem 0.50em;
        }

        .tbl_price_input {
            width: 60px;
        }

        .error {
            color: red !important;
        }

    </style>
@endsection



@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <form onsubmit="return false" id="addForm">
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <h3 class="card-title">Bands</h3>
                        </div>
                        <!--begin::Form-->
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="hidden" name="id" id="band_id" value="{{ !empty($brandData->id) ? $brandData->id : '' }}">
                                    <input type="text" name="name" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"  id="name" value="{{ !empty($brandData->name) ? $brandData->name : '' }}" class="form-control" placeholder="Enter Name" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label>Dimensions Table Pricing</label><br />
                                    <button type="button" class="btn btn-primary" onclick="cloneRow()">Add Row</button>
                                    <button type="button" class="btn btn-primary" onclick="cloneColumn()">Add
                                        Column</button>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <span class="error_messages text-danger"></span>
                                            </div>
                                        </div>
                                    <table class="mt-2" border="1" id="tbl_custom_price">
                                        @php
                                            $outerLoop = 0;
                                        @endphp
                                        @if(!empty($priceArr))
                                            @foreach($priceArr as $length => $widths)
                                                <tr>
                                                    @php
                                                        $innerLoop = 0;
                                                        $lenCol = number_format((float)$length, 0, '', '');
                                                    @endphp
                                                    @foreach($widths as $width => $arr)
                                                        @php
                                                            $withCol = number_format((float)$width, 0, '', '');
                                                        @endphp
                                                        @if($outerLoop == 0)
                                                            @if($innerLoop == 0)
                                                                <td></td>
                                                            @elseif($innerLoop == 1)
                                                                <td class="col_{{ $withCol }}">
                                                                    <button type="button" class="btn btn-primary remove_column" data-num="{{ $withCol }}" style="display: none;" >-</button>
                                                                </td>
                                                            @elseif(($innerLoop + 1) == count($widths))
                                                                <td></td>
                                                            @else
                                                                <td class="col_{{ $withCol }}">
                                                                    <button type="button" class="btn btn-primary remove_column" data-num="{{ $withCol }}" >-</button>
                                                                </td>
                                                            @endif
                                                        @elseif($outerLoop == 1)
                                                            @if($innerLoop == 0)
                                                                <td>L/W</td>
                                                            @elseif(($innerLoop + 1) == count($widths))
                                                                <td></td>
                                                            @else
                                                                <td class="col_{{ $withCol }}">
                                                                    {{-- <span class="text-danger">*</span> --}}
                                                                    <input type="text" name="width[{{ $withCol }}]" class="tbl_price_input width" min="0.01" value="{{ $withCol }}" placeholder="width">

                                                                </td>
                                                            @endif
                                                        @else
                                                            @if($innerLoop == 0)
                                                                <td>
                                                                    <input type="text" name="length[{{ $lenCol }}]" class="tbl_price_input length" min="0.01" value="{{ $lenCol }}" placeholder="length">
                                                                </td>
                                                            @elseif(($innerLoop + 1) == count($widths))
                                                                <td>
                                                                    @if($outerLoop == 2)
                                                                        <button type="button" class="btn btn-primary remove_row" style="display: none;">-</button>
                                                                    @else
                                                                        <button type="button" class="btn btn-primary remove_row" >-</button>
                                                                    @endif
                                                                </td>
                                                            @else
                                                                <td class="col_{{ $withCol }}">
                                                                    <input type="text" name="price[{{ $lenCol  }}][{{ $withCol }}]" id="price_{{$lenCol}}_{{$withCol}}" class="tbl_price_input price" min="0.01" value="{{ $arr['price'] }}" placeholder="price">
                                                                </td>
                                                            @endif
                                                        @endif
                                                        @php
                                                            $innerLoop++;
                                                        @endphp
                                                    @endforeach
                                                </tr>
                                                @php
                                                    $outerLoop++;
                                                @endphp
                                            @endforeach
                                        @else
                                        <tr>
                                            <td></td>
                                            <td class="col_0">
                                                <button type="button" class="btn btn-primary remove_column" data-num="0" style="display: none;" >-</button>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>L/W</td>
                                            <td class="col_0">
                                                <input type="text" name="width[0]" class="tbl_price_input width" min="0.01" value="" placeholder="width">
                                                {{-- <span class="text-danger">*</span> --}}
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="length[0]" class="tbl_price_input length" min="0.01" placeholder="length">
                                            </td>
                                            <td class="col_0">
                                                <input type="text" name="price[0][0]" id="price_0_0" class="tbl_price_input price"  min="0.01" placeholder="price">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary remove_row" style="display: none;">-</button>
                                            </td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            <!--end: Code-->
                        </div>
                        <div class="card-footer text-right">
                            <button type="button" id="btn_save" class="btn btn-primary mr-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page_level_js_plugins')
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
@endsection

@section('page_level_js')
    <script type="text/javascript">
        var elindexRow = {{ (($totalTblRow == 0) ? 1 : $totalTblRow)  }};
        var elindexCol = {{ (($totalTblCol == 0) ? 1 : $totalTblCol) }};
        $(document).ready(function() {
            elindexRow = {{ (($totalTblRow == 0) ? 1 : $totalTblRow) }};
            elindexCol = {{ (($totalTblCol == 0) ? 1 : $totalTblCol) }};
            var validator = $("#addForm").validate({
                //ignore: ":hidden:not(.selectpicker)",
                rules: {
                    name: {
                        required: true
                    },
                },
                errorPlacement: function(error, element) {
                    var elem = $(element);
                    if (elem.hasClass("tags") || elem.hasClass("categories") || elem
                        .hasClass("colors") || elem
                        .hasClass("taxes")) {
                        element = elem.parent();
                        error.insertAfter(element);
                    }
                    else if(elem.hasClass("width") || elem.hasClass("length") || elem.hasClass("price")){
                         $('.error_messages').html('');
                         $('.error_messages').html('All fileds are required, should be numeric and greater than 0..');
                    }
                    else {
                        error.insertAfter(element);
                    }
                }
            });
             $(document).ready(function(){
                jQuery.validator.addClassRules("length", {
                    required: true,
                    });
                jQuery.validator.addClassRules("width", {
                    required: true,
                    });
                jQuery.validator.addClassRules("price", {
                    required: true,
                    });
             });
            $(document).on('click', '#btn_save', function() {
                var validate = $("#addForm").valid();

                if (validate) {
                    var form = $('#addForm')[0];
                    var form_data = new FormData(form);
                    //  var form_data = $("#addForm").serializeArray();
                    var summernote = $('#summernote').summernote('code');
                    $.ajax({
                        type: "POST",
                        //enctype: 'multipart/formq-data',
                        url: "{{ route('bandSubmit') }}", // your php file name
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
                                window.location = "{{ route('bandList') }}";
                                //  $('#add_edit_modal').modal('hide');
                                // table.ajax.reload();
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

            $(document).on('click', '.remove_row', function() {
                $(this).parent().parent().remove();
            });

            $(document).on('click', '.remove_column', function() {
                var num = $(this).data('num');
                $('.col_' + num).remove();
            });
        });

        function cloneRow() {
            var lastRow = $('#tbl_custom_price').find("tr:last");
            var new_data = lastRow.clone();
            new_data.find('td:last').find('button').removeAttr('style');
            new_data.find('td').each(function() {
                if ($(this).find('input').hasClass('price')) {
                    var priceId = $(this).find('input').attr('id');
                    $(this).find('input').attr('id', priceId.replace(/\d+/,elindexRow));
                    var priceName = $(this).find('input').attr('name');
                    $(this).find('input').attr('name', priceName.replace(/\d+/,(elindexRow)));
                }
                if (new_data.find('input').hasClass('length')) {
                    var lengthName = new_data.find('input').attr('name');
                    new_data.find('input.length').attr('name', lengthName.replace(/\d+/, parseInt(elindexRow)));
                }
                $(this).find('input').val('');
            });

            lastRow.after(new_data);
            elindexRow++;
        }

        function cloneColumn() {
            $('#tbl_custom_price tr').each(function(k, v) {
                var new_data = $('td:nth-last-child(2)', this).clone();
                var tdClass = $('td:nth-last-child(2)').attr('class');
                if (new_data.find('input').hasClass('price')) {
                    var priceId = new_data.find('input').attr('id');
                    var priceName = new_data.find('input').attr('name');
                    var tempArr = priceId.split('_');
                    var item_fist_index = tempArr[1];
                    var item_sec_index = tempArr[2];
                    var indx = elindexCol;
                    new_data.find('input').attr('name', priceName.replace("[" + item_fist_index + "][" + item_sec_index + "]", "[" + item_fist_index + "][" + indx + "]"));
                    new_data.find('input').attr('id', priceId.replace("_" + item_fist_index + "_" + item_sec_index, "_" + item_fist_index + "_" + indx));
                }
                if (new_data.find('input').hasClass('width')) {
                    var widthName = new_data.find('input').attr('name');
                    new_data.find('input').attr('name', widthName.replace(/\d+/, elindexCol));
                }
                new_data.find('input').val('');
                var dataNum = $('td:nth-last-child(2) button').attr('data-num');
                new_data.find('button').removeAttr('style');
                new_data.attr('class', tdClass.replace(/\d+/, elindexCol));
                new_data.find('button').attr('data-num', dataNum.replace(/\d+/, elindexCol));
                new_data.insertAfter($('td:nth-last-child(2)', this));
            });
            elindexCol++
        }

        function additionalValidtion() {
            $('.width').each(function() {
                var id = $(this).attr('id');
                $('#'+id).rules("add",{
                    required: true
                });
            });

            // $('.v_storage').each(function() {
            //     var id = $(this).attr('id');
            //     $('#'+id).rules("add",{
            //         required: true
            //     });
            // });
            // $('.v_price').each(function() {
            //     var id = $(this).attr('id');
            //     $('#'+id).rules("add",{
            //         required: true
            //     });
            // });
            // $('.quality_description').each(function() {
            //     var id = $(this).attr('id');
            //     $('#'+id).rules("add",{
            //         required: true
            //     });
            // });
        }
    </script>
@endsection

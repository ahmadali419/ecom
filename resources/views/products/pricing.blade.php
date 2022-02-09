@extends('layouts.app')

@section('title', 'Product Pricing')
@section('description', 'Product Pricing')

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
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
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
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="1"></rect>
                                        <path
                                            d="M5,10 L7,10 C7.55228475,10 8,10.4477153 8,11 L8,13 C8,13.5522847 7.55228475,14 7,14 L5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 L14,7 C14,7.55228475 13.5522847,8 13,8 L11,8 C10.4477153,8 10,7.55228475 10,7 L10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,13 C14,13.5522847 13.5522847,14 13,14 L11,14 C10.4477153,14 10,13.5522847 10,13 L10,11 C10,10.4477153 10.4477153,10 11,10 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,7 C20,7.55228475 19.5522847,8 19,8 L17,8 C16.4477153,8 16,7.55228475 16,7 L16,5 C16,4.44771525 16.4477153,4 17,4 Z M17,10 L19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 L17,14 C16.4477153,14 16,13.5522847 16,13 L16,11 C16,10.4477153 16.4477153,10 17,10 Z M5,16 L7,16 C7.55228475,16 8,16.4477153 8,17 L8,19 C8,19.5522847 7.55228475,20 7,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,17 C4,16.4477153 4.44771525,16 5,16 Z M11,16 L13,16 C13.5522847,16 14,16.4477153 14,17 L14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 L10,17 C10,16.4477153 10.4477153,16 11,16 Z M17,16 L19,16 C19.5522847,16 20,16.4477153 20,17 L20,19 C20,19.5522847 19.5522847,20 19,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,17 C16,16.4477153 16.4477153,16 17,16 Z"
                                            fill="#000000"></path>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                            <h3 class="card-label">Product Pricing</h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Dropdown-->
                            <div class="dropdown dropdown-inline mr-2"></div>
                            <!--end::Dropdown-->
                            <!--begin::Button-->
                            {{-- <a href="{{ route('productNew') }}" class="btn btn-primary font-weight-bolder" id="btn_add_new">
                        <span class="svg-icon svg-icon-md">
                            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo5\dist/../src/media/svg/icons\Code\Plus.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10"/>
                                    <path d="M11,11 L11,7 C11,6.44771525 11.4477153,6 12,6 C12.5522847,6 13,6.44771525 13,7 L13,11 L17,11 C17.5522847,11 18,11.4477153 18,12 C18,12.5522847 17.5522847,13 17,13 L13,13 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,13 L7,13 C6.44771525,13 6,12.5522847 6,12 C6,11.4477153 6.44771525,11 7,11 L11,11 Z" fill="#000000"/>
                                </g>
                            </svg><!--end::Svg Icon-->
                        </span>Add Product</a> --}}
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Search Form-->
                        {{-- <form class="kt-form kt-form--fit">
                        <div class="row mb-6">
                            <div class="col-lg-3 mb-lg-0 mb-2">
                                <label>Name:</label>
                                <input type="text" class="form-control datatable-input" placeholder="E.g: product   a name" data-col-index="1" />
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
                    </form> --}}
                        <!--begin: Datatable-->
                        <!--begin: Datatable-->
                        <form id="productPricing">
                        <div class="table-responsive ">
                            <table class="table table-bordered table-hover table-checkable my-table" id="datatableList">
                                <thead>
                                    <tr>
                                        {{-- <th>Sr</th> --}}
                                        <th>Store Name</th>
                                        <th>Product Name</th>
                                        <th>Min Length</th>
                                        <th>Min Width</th>
                                        <th>Buying Price</th>
                                        <th>Margin(%)</th>
                                        <th>VAT(%)</th>
                                        <th>Discount(%)</th>
                                        <th>Selling Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$allProducts->isEmpty())
                                    @foreach ($allProducts as $productObj)
                                    <tr class="targetfields">
                                                <input type="hidden" name="sppm_id[]" value="{{$productObj->sppm_id}}">
                                                <td>

                                                    {{ $productObj->StoreName }}
                                                </td>
                                                <td>
                                                    {{ $productObj->name }}
                                                </td>
                                                <td>
                                                    {{ $productObj->min_order_length }}
                                                </td>
                                                <td>
                                                    {{ $productObj->min_order_width }}
                                                </td>
                                                <td>
                                                    @php
                                                        $buyingPrice = $productObj->min_product_price - ($productObj->min_product_price * ($productObj->contract_discount / 100));
                                                    @endphp
                                                    <input type="hidden" name="buy_price[{{ $productObj->sppm_id }}]" class="buying_price" id="buying_price_{{ $productObj->id }}"  value="{{ $buyingPrice }}" data-product_id="{{ $productObj->id }}">
                                                    {{ $buyingPrice }}
                                                </td>
                                                <td>
                                                    <input type="number" name="margin[{{ $productObj->sppm_id }}]" value="{{ !empty($productObj->margin) ? $productObj->margin : '0' }}"
                                                        class="form-control margin" id="margin_{{ $productObj->id }}" min="0" placeholder="%" data-product_id="{{ $productObj->id }}">
                                                </td>
                                                <td>
                                                    <input type="number" name="vat[{{ $productObj->sppm_id }}]" value="{{ !empty($productObj->vat) ? $productObj->vat : '0' }}"
                                                        class="form-control vat" id="vat_{{ $productObj->id }}" min="0" placeholder="%" data-product_id="{{ $productObj->id }}">
                                                </td>
                                                <td>
                                                    <input type="number" name="discount[{{ $productObj->sppm_id }}]"
                                                        value="{{ !empty($productObj->discount) ? $productObj->discount : '0' }}"
                                                        class="form-control discount" id="discount_{{ $productObj->id }}" placeholder="%" data-product_id="{{ $productObj->id }}">
                                                </td>
                                                <td>
                                                    <input type="number" name="sale_price[{{ $productObj->sppm_id }}]"
                                                        value="{{ !empty($productObj->sale_price) ? $productObj->sale_price : $buyingPrice }}"
                                                        class="form-control selling_price" id="selling_price_{{ $productObj->id }}" data-product_id="{{ $productObj->id }}" readonly>
                                                </td>
                                        @endforeach
                                        </tr>

                                    @endif
                                </tbody>
                            </table>
                        </div>
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button type="button" id="btn_save"
                                                    class="btn btn-primary mr-2">Save</button>
                                </div>
                            </div>
                        </form>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection

@section('page_level_js')
    <script src="{{ asset('assets/plugins/custom/jqueryui/jquery-ui.js?v=7.0.4') }}"></script>

    <script type="text/javascript">
        // $(document).on('change','#margin',function(){
        //     // console.log('yes');
        //     var buyingPrice = $('#buying_price').val();
        //     var number = buyingPrice;
        //     // console.log(number);
        //  
        // //The percent that we want to get.
        // //i.e. We want to get 50% of 120.
        // var percentToGet = $(this).val();
        //  
        // //Calculate the percent.
        // var percent = (percentToGet / 100) * number;

        //   var totalSellingPrice = parseInt(buyingPrice) + parseInt(percent);
        //  $('#selling_price').val('');
        //  $('#selling_price').val(totalSellingPrice);

        // });
        $(function() {
            $(".margin, .vat, .discount").on('keyup', function() {
                var sellingPrice = 0;
                var discount = 0;
                var vat = 0;
                var product_id = $(this).data('product_id');
                var margin = parseFloat($("#margin_"+product_id).val());
                var vat = parseFloat($("#vat_"+product_id).val());
                var discount = parseFloat($("#discount_"+product_id).val());
                var buyingPrice = parseFloat($("#buying_price_"+product_id).val());
                // if (margin >= 0) {
                //     var percentToGet = (margin) ? margin : 0;
                //     var totalMargin = (percentToGet / 100) * buyingPrice;
                //     sellingPrice  = parseFloat(buyingPrice) + parseFloat(totalMargin);
                // }
                // if (vat >= 0) {
                //     buyingPrice = (sellingPrice > 0) ? sellingPrice : buyingPrice;
                //     var vatTax =  (buyingPrice * (vat / 100));
                //     sellingPrice =  parseFloat(buyingPrice) + parseFloat(vatTax) ;
                // }
                // if (discount >=0) {
                //     buyingPrice  = (sellingPrice > 0) ? sellingPrice : buyingPrice;
                //     var discount = (buyingPrice * (discount / 100));
                //     sellingPrice = parseFloat(buyingPrice) - parseFloat(discount) ;
                // }
                var charges = (margin+vat) - discount;
                sellingPrice = (buyingPrice + (buyingPrice * (charges/100)));
                $("#selling_price_"+product_id).val(parseFloat(sellingPrice).toFixed(2));
            });
        });
        $(document).on('click', '#btn_save', function() {
            var form = $('#productPricing')[0];
            var form_data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{ route('StoreProductSellingPrice') }}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",

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
                       location.reload();
                        // $('#previewModal').modal('show');
                    }
                    if (data.status == 'error') {
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
                        toastr.warning(data.message);
                    }
                },
                error: function(errorString) {}
            });
        });
    </script>
@endsection

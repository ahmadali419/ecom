@extends('layouts.app')

@section('title', 'New Product')
@section('description', 'New Product')

@section('page_level_css')
<link href="https://transloadit.edgly.net/releases/uppy/v1.6.0/uppy.min.css" rel="stylesheet">
<link href="{{ asset('assets/plugins/custom/uppy/uppy.bundle.css?v=7.0.4') }}" rel="stylesheet" type="text/css" />
<style>
#addForm {
    width: 100%;
}

.star {
    color: red;
}

.error {
    color: #F64E60 !important;
}

.remove {
    display: block;
    color: #f64e60;
    text-align: center;
    cursor: pointer;
    margin-top: 10px;
}

.remove:hover {
    background: white;
    color: black;
}

.preview-images-zone {
    width: 100%;
    border: 1px solid #ddd;
    min-height: 180px;
    /* display: flex; */
    padding: 5px 5px 0px 5px;
    position: relative;
    overflow: auto;
}

.preview-images-zone>.preview-image:first-child {
    height: 185px;
    width: 185px;
    position: relative;
    margin-right: 5px;
}

.preview-images-zone>.preview-image {
    height: 90px;
    width: 90px;
    position: relative;
    margin-right: 5px;
    float: left;
    margin-bottom: 5px;
}

.preview-images-zone>.preview-image>.image-zone {
    width: 100%;
    height: 100%;
}

.preview-images-zone>.preview-image>.image-zone>img {
    width: 100%;
    height: 100%;
}

.preview-images-zone>.preview-image>.tools-edit-image {
    position: absolute;
    z-index: 100;
    color: #fff;
    bottom: 0;
    width: 100%;
    text-align: center;
    margin-bottom: 10px;
    display: none;
}

.preview-images-zone>.preview-image>.image-cancel {
    font-size: 18px;
    position: absolute;
    top: 0;
    right: 0;
    font-weight: bold;
    margin-right: 10px;
    cursor: pointer;
    display: none;
    z-index: 100;
}

.preview-image:hover>.image-zone {
    cursor: move;
    opacity: .5;
}

.preview-image:hover>.tools-edit-image,
.preview-image:hover>.image-cancel {
    display: block;
}

.ui-sortable-helper {
    width: 90px !important;
    height: 90px !important;
}

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
                <div class="row">
                    <div class="col-lg-9 col-md-6">
                        <div class="card card-custom gutter-b  example-compact">
                            <div class="card-header">
                                <h3 class="card-title">Products</h3>
                            </div>
                            <!--begin::Form-->
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <input type="hidden" name="product_id"
                                            value="{{!empty($singleProduct->id) ? $singleProduct->id:-1}}"
                                            id="product_id">
                                        <input type="hidden" name="old_image"
                                            value="{{!empty($singleProduct->main_image) ? $singleProduct->main_image:''}}">
                                        <label>Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name"
                                            value="{{!empty($singleProduct->name) ? $singleProduct->name:''}}"
                                               onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode > 95 && event.charCode < 106) || (event.charCode > 47 && event.charCode < 58) || (event.charCode==32)" class="form-control" placeholder="Enter Product Name" />
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>SKU <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="sku"
                                            value="{{!empty($singleProduct->sku) ? $singleProduct->sku:''}}" name="sku"
                                            placeholder="SKU" />
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <div class="field row p-2" align="left">
                                            <div class="col-12">
                                                <label class="col-form-label">Cover</label>
                                            </div>
                                            <div class="col-12 row mx-4 border rounded p-4">
                                                <input class="w-100 mx-3" type="file" id="image_cover"
                                                    name="image_cover" />
                                                <div id="frames1">
                                                    @if(!empty($singleProduct->main_image))
                                                    <img src="{{asset('product/coverimage').'/'.$singleProduct->main_image}}"
                                                        style="margin-top:20px; text-align:center" width="50px"
                                                        height="50px">
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row p-2">
                                            <div class="col-12">
                                                <label class="col-form-label">Product Images</label>
                                            </div>
                                            @php
                                            if(!empty($singleProduct)){
                                            $productImages = [];
                                            foreach ($singleProduct->product_images as $key => $imgObj) {
                                            $productImages[] = [
                                            'id' =>$imgObj->id,
                                            'src'=> asset('product/productimages/').'/'.$imgObj->image
                                            ];
                                            }
                                            }
                                            @endphp
                                            <div class="col-12 mx-4 border rounded p-4">
                                                <div class="input-images"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group col-lg-6">
                                            <div class="field row p-2" align="left">
                                                <div class="col-12">
                                                    <label class="col-form-label">Product Images</label>
                                                </div>
                                                <div class="col-12 row mx-4 border rounded p-4">
                                                    <input class="w-100 mx-3" type="file" id="product_images" name="product_images[]" multiple />
                                                </div>
                                            </div>
                                        </div> -->
                                    <div class="row">
                                        <div class="col-12">
                                            <span class="text-danger" id="measure_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-12">

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <div class="w-100">
                                                        <label for="exampleSelectd">Band<span
                                                                class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="w-100">
                                                        <select class="form-control select2 kt-select2-general band_id"
                                                            id="band_id" name="band_id">
                                                            <option value="" selected>Select Band</option>
                                                            @foreach($bands as $band)
                                                            <option value="{{$band->id}}"
                                                                {{!empty($singleProduct->band_id) && $singleProduct->band_id== $band->id   ? 'selected' :''}}>
                                                                {{ucfirst($band->name)}}</option>
                                                            @endforeach;

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">

                                                    <label>Min Order Length <span class="text-danger">*</span></label>
                                                    <input type="hidden" name="min_length" id="min_length">
                                                    <input type="hidden" name="min_width" id="min_width">
                                                    <input type="number" name="min_order_len" id="min_order_len" readonly
                                                        value="{{!empty($singleProduct->min_order_length) ? $singleProduct->min_order_length:''}}"
                                                        class="form-control" placeholder="Enter Length" />
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">

                                                    <label>Min Order Width <span class="text-danger">*</span></label>
                                                    <input type="number" name="min_order_wid" id="min_order_wid" readonly
                                                        value="{{!empty($singleProduct->min_order_width) ? $singleProduct->min_order_width:''}}"
                                                        class="form-control" placeholder="Enter width" />
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <!-- End Dimensions-->
                                    <div class="form-group col-lg-12">
                                        <label>Description<span class="text-danger">*</span></label>
                                        <div class="col-lg-12 col-md-9 col-sm-12">
                                            <textarea class="summernote" name="summernote"
                                                id="summernote">@if(!empty($singleProduct->description)){!!json_decode($singleProduct->description)!!}@endif</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label>Features<span class="text-danger">*</span></label>
                                        <div class="container">
                                            @if(!empty($singleProduct->features))

                                            @foreach (unserialize($singleProduct->features) as $key=>$productObj)
                                            @if($key==0)
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="feature[]"
                                                        value="{{$productObj}}" placeholder="Enter Feature" />
                                                </div>
                                                <div class="col-lg-2">
                                                    <button type="button" onclick="addfeature(0)"
                                                        class="btn btn-icon btn-success btn-sm mr-2 add"><i
                                                            class="icon-xl fas fa-plus-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @elseif($key > 0)
                                            <div class="row" id="d_{{$key}}">
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="feature[]"
                                                        value="{{$productObj}}" placeholder="Enter Features">
                                                </div>
                                                <div class="col-lg-2">
                                                    <button type="button" onclick="removeRequirementdb({{$key}})"
                                                        class="btn btn-icon btn-danger add  btn-sm mr-2">
                                                        <i class="icon-xl fas fa-minus-circle"></i> </button>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                            @else
                                            <div class="row">
                                                <div class="col-lg-10">
                                                    <input type="text" class="form-control" name="feature[]"
                                                        placeholder="Enter Feature" />
                                                </div>
                                                <div class="col-lg-2">
                                                    <button type="button" onclick="addfeature(0)"
                                                        class="btn btn-icon btn-success btn-sm mr-2 add"><i
                                                            class="icon-xl fas fa-plus-circle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @endif
                                            <div id="newfeature"></div>
                                        </div>

                                    </div>
                                </div>
                                <!--end: Code-->
                            </div>
                            <div class="card-footer">
                                <button type="button" id="btn_save" class="btn btn-primary mr-2">Submit</button>
                               {{-- <button type="reset" class="btn btn-secondary">Cancel</button>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <!--begin::Card-->
                        <div class="card card-custom gutter-b  example-compact">
                            <div class="card-header">
                                <h3 class="card-title">Product Types</h3>
                            </div>
                            <!--begin::Form-->

                            <div class="card-body">
                                @php
                                if(!empty($singleProduct->product_tags))
                                {
                                $tagIds=array();
                                foreach($singleProduct->product_tags as $tagsc)
                                {
                                $tagIds[]=$tagsc->tag_id;
                                }
                                //$selectedTags=implode(',', $tagIds);
                                }
                                @endphp
                                <div class="form-group">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-lg-9">
                                            <label for="exampleSelectd">Tags<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-3">
                                             <i data-toggle="modal" data-target="#addTagsModel" class="icon-xl danger fas fa-plus-circle"></i>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <select class="form-control select2 tags" id="kt_select2_10" name="tags[]"
                                            multiple>
                                            @foreach($tags as $tag)
                                            <option value="{{$tag->id}}"
                                                {{!empty($tagIds) && in_array($tag->id,$tagIds)   ? 'selected' :''}}>
                                                {{$tag->name}}</option>
                                            @endforeach;

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row d-flex justify-content-between">
                                        <div class="col-lg-9">
                                            <label for="exampleSelectd">Categories<span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-lg-3">
                                             <i data-toggle="modal" data-target="#addCategory" class="icon-xl danger fas fa-plus-circle"></i>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <select class="form-control select2 kt-select2-general categories" id="category"
                                            name="category_id" required>
                                            <option value="" selected>Select Category</option>
                                            @foreach($category as $categorys)
                                            <option value="{{$categorys->id}}"
                                                {{!empty($singleProduct->category_id) && $singleProduct->category_id== $categorys->id   ? 'selected' :''}}>
                                                {{$categorys->name}}</option>
                                            @endforeach;

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-lg-9">
                                    <label for="exampleSelectd">Colors <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-lg-3">
                                        <i data-toggle="modal" data-target="#staticBackdrop2" class="icon-xl danger fas fa-plus-circle"></i>
                                    </div>
                                </div>
                                    <div class="w-100">
                                        <select class="form-control  select2 kt-select2-general colors" name="color" id="color"
                                            required>
                                            <option value="">Select Colors<span class="star">*</span></option>
                                            @foreach($color as $colors)
                                            <option value="{{$colors->id}}"
                                                {{!empty($singleProduct->color_id) && $singleProduct->color_id== $colors->id   ? 'selected' :''}}>
                                                {{$colors->name}}</option>
                                            @endforeach;
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal-->
<div class="modal fade" id="addCategory" data-backdrop="static"
     tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form onsubmit="return false" id="catogeryform">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">
                        Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <h6 class="text-dark">Category Info</h6>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Category Name<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control catogeryname" name="name" id="catogeryname" placeholder="Enter Category name" required />
                        </div>
                        <div class="form-group col-lg-6 col-md-6 col-6">
                            <label class="col-form-label">Profile Photo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" id="image1" name="category_logo"  class="upload-image-site w-100"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold"  id="btn_category">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
<br>
<!-- Modal-->
<div class="modal fade" id="addTagsModel" data-backdrop="static" tabindex="-1"
     role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form onsubmit="return false" id="tagfrom">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Add Tag</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="erole">Tag Name</label>
                        <input type="text" name="tag" class="form-control" id="addtags"
                               placeholder="Enter Tag" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                            id="btnReset">Close</button>
                    <button type="button" class="btn btn-primary" id="tags_btn" >Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<!-- Modal-->
<div class="modal fade" id="staticBackdrop2" data-backdrop="static"
     tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel3"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form onsubmit="return false" id="colorfrom">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">
                        Add Color</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <h6 class="text-dark">Color Info</h6>
                        </div>
                        <div class="col-md-12">
                            <label class="col-form-label">Color Name<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="colorval" placeholder="Enter Color name" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light-primary font-weight-bold"
                            data-dismiss="modal">Close</button>
                    <button type="button" id="save_colore" class="btn btn-primary font-weight-bold">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('page_level_js_plugins')
<script src="{{ asset('assets/plugins/custom/jqueryui/jquery-ui.js?v=7.0.4') }}"></script>
<script src="{{ asset ('assets/dist/image-uploader.min.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>
<script src="{{ asset ('assets/js/pages/crud/forms/editors/summernote.js?v=7.0.4') }}"></script>
<script src="{{ asset ('assets/js/pages/crud/forms/widgets/select2.js?v=7.0.4') }}"></script>


@endsection

@section('page_level_js')

<script type="text/javascript">
@if(isset($productImages) && !empty($productImages))
var images = <?php echo json_encode($productImages) ?>; // don't use quotes
$('.input-images').imageUploader({
    preloaded: images
});
@else
$('.input-images').imageUploader({
    imagesInputName: 'images',
    //preloadedInputName: 'preloaded',
    label: 'Drag & Drop files here or click to browse'
});
@endif
var validator = $("#addForm").validate({
    ignore: ":hidden:not(.selectpicker)",
    rules: {
        name: {
            required: true
        },
        sku: {
            required: true
        },
        summernote: {
            required: true
        },
        'tags[]': {
            required: true
        },
        color: {
            required: true
        },
        category_id: {
            required: true
        },
        'images[]': {
            required: true
        },

        image_cover: {
            required: true
        },
        band_id: {
            required: true
        },
        min_order_len: {
            required: true
        },
        min_order_wid: {
            required: true
        },
        'feature[]': {
            required: true
        },
    },
    errorPlacement: function(error, element) {
        var elem = $(element);
        if (elem.hasClass("tags") || elem.hasClass("categories") || elem
            .hasClass("colors") || elem
            .hasClass("taxes") || elem.hasClass("cover-images") || elem.hasClass("band_id")) {
            element = elem.parent();
            error.insertAfter(element);
        } else {
            error.insertAfter(element);
        }
    }
});

$(document).on('click', '#btn_save', function() {
    // alert('yesss');
    var length = $('#min_order_len').val();
    var width = $('#min_order_wid').val();
    var minlength = $('#min_length').val();
    var minwidth = $('#min_width').val();
    if (minlength > length && minwidth < width) {
        $('#measure_error').html('Please select min or max between given measurements');
        return;
    }
    $('#measure_error').html('');
    var productId = $('#product_id').val();

    if (productId != -1) {

        $('#image_cover').rules('add', {
            required: false // overwrite an existing rule
        });
        $('.cover-images').rules('add', {
            required: false // overwrite an existing rule
        });
    }

    var validate = $("#addForm").valid();
    if (validate) {
        var form = $('#addForm')[0];
        var form_data = new FormData(form);
        //  var form_data = $("#addForm").serializeArray();
        var summernote = $('#summernote').summernote('code');
        $.ajax({
            type: "POST",
            //enctype: 'multipart/formq-data',
            url: "{{route('productSubmit')}}", // your php file name
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
                    window.location = "{{route('productList')}}";
                    //  $('#add_edit_modal').modal('hide');
                    // table.ajax.reload();
                } else {
                    Swal.fire("Sorry!", data.message, "error");
                }
            },
            error: function(errorString) {
                Swal.fire("Sorry!", "Something went wrong please contact to admin", "error");
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
var number = 1;

function addfeature(id) {
    let html = `
            <div class="test_${number} feature">
                <div class="row">
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="feature[]" placeholder="Enter Features">
                    </div>
                    <div class="col-lg-2">
                    <button type="button" onclick="remove(${number})" class="btn btn-icon btn-danger add  btn-sm mr-2">
                         <i class="icon-xl fas fa-minus-circle"></i> </button>
                    </div>
                </div>
            </div>`;

    $('#newfeature').append(html);
    number++;
}

function remove(id) {
    //alert(id);
    $('.test_' + id).remove();
}

function removeRequirementdb(id) {
    $('#d_' + id).remove();
}
$(document).ready(function() {
    var id = $('.image-uploader').find('input').addClass('cover-images');
    $('#image_cover').change(function() {
        $("#frames1").html('');
        for (var i = 0; i < $(this)[0].files.length; i++) {
            $("#frames1").append('<img src="' + window.URL.createObjectURL(this.files[i]) +
                '" style="margin-top:20px; text-align:center" width="50px" height="50px"/>');
        }
    });
});


$(".delete-image").on('click', function() {
    var id = $(this).closest('.uploaded-image').find('input').val();
    var form_data = new FormData();
    form_data.append('id', id);
    $.ajax({
        type: "POST",
        url: "{{route('removeImage')}}", // your php file name
        data: form_data,
        dataType: "json",
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if (data.status == 'success') {

            } else {

            }
        },
        error: function(errorString) {
            alert('contact to admin');
        }
    });

});

$(document).on('change', '#band_id', function() {
    var id = $(this).val();
    var form_data = new FormData();
    form_data.append('id', id);
    $.ajax({
        type: "POST",
        url: "{{route('product.prices')}}", // your php file name
        data: form_data,
        dataType: "json",
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if (data.status == 'success') {
                $("#min_length").val("");
                $("#min_order_len").val("");
                $("#min_length").val(data.prices.Minlength);
                $("#min_width").val("");
                $("#min_order_wid").val("");
                $("#min_width").val(data.prices.Minwidth);

                //$("#min_order_len").attr("readonly", " ");
                //$("#min_order_wid").attr("readonly", " ");
                $("#min_order_len").val(data.prices.Minlength);
                $("#min_order_wid").val(data.prices.Minwidth);
            } else {

            }
        },
        error: function(errorString) {
            alert('contact to admin');
        }
    });
});
</script>
<script type="text/javascript">
    $(document).on('click', '#tags_btn', function(){
       var  name = document.getElementById("addtags").value;
        if(name) {
            $.ajax({
                type: "POST",
                url: "{{route('tagSubmit')}}", // your php file name
                data: {'name': name},
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
                        $('#addTagsModel').modal('hide');
                        $('#kt_select2_10').append("<option selected>"+name+"</option>");
                        $('#addtags').val('');
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
    var input = document.getElementById("tagfrom");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("tags_btn").click();
        }
    });
    $(document).on('click', '#btn_category', function(){
      var  name = document.getElementById("catogeryname").value;
        if(name) {
            var form = $("#catogeryform")[0];
            var form_data = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{route('categorySubmit')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
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
                        $('#addCategory').modal('hide');
                        $('#category').append("<option value="+data.catogeryId+" selected>"+name+"</option>");
                        $('.catogeryname').val('');
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

    var input = document.getElementById("catogeryform");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("btn_category").click();
        }
    });

    $(document).on('click', '#save_colore', function(){
        var  name = document.getElementById("colorval").value;
        if(name) {
            $.ajax({
                type: "POST",
                url: "{{route('colorSubmit')}}", // your php file name
                data: {'name': name},
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
                        $('#staticBackdrop2').modal('hide');
                        $('#color').append("<option value="+data.colorId+" selected>"+name+"</option>");
                        $('#colorval').val('');

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
    var input = document.getElementById("colorfrom");
    input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("save_colore").click();
        }
    });
</script>

@endsection


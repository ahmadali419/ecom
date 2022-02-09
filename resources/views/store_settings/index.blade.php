@extends('layouts.app')

@section('title', 'Store Setting')

@section('page_level_css_plugins')
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?v=7.0.4') }}" rel="stylesheet"
        type="text/css" />


@endsection

@section('page_level_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <link href="{{ asset('assets/plugins/custom/multiselect/multi-select.css?v=7.0.4') }}" rel="stylesheet"
        type="text/css" />
    <style>
        input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.img_pre{
    height: 40% !important;
}

.img-fluid{
    height: none;
}
.remove:hover {
  background: white;
  color: black;
}
        #addForm {
            width:100%;
        }
        .error {
            color: red !important;
        }

        .ms-list {
            margin-top: 10px !important;
            margin-bottom: 10px !important;
        }

        .btn_multiselect_search_option {
            margin-top: 5px;
            width: 100%;
        }

        .image-upload-one{
            grid-area: img-u-one;
            display: flex;
            /* justify-content: center; */
          }
          .image-upload-container{
            display: grid;
            grid-template-areas: 'img-u-one img-u-two img-u-three img-u-four img-u-five img-u-six';
          }
          .center {
            display:inline;
            margin: 3px;
          }

          .form-input {
            width:100px;
            height:100px;
            padding:3px;
            background:#fff;
            border:2px dashed dodgerblue;
          }
          /* .form-input-logo {
            width:180px !important;
            height:auto !important;
          } */
          .form-input input {
            display:none;
          }
          .form-input label {
            display:block;
            width:100%;
            height:100%;
            max-height: 100px;
            background:#333;
            border-radius:10px;
            cursor:pointer;
          }

          .form-input img {
            width:100%;
            height: 100%;
            margin: 2px;
            opacity: .4;
          }

          .imgRemove{
            position: relative;
            bottom: 114px;
            left: 68%;
            background-color: transparent;
            border: none;
            font-size: 30px;
            outline: none;
          }
          .imgRemove::after{
            content: ' \21BA';
            color: red;
            font-weight: 900;
            border-radius: 8px;
            cursor: pointer;
          }

          .small{
            color: #fff;
          }

          .color_dropdown {
              padding: 2px 12px;
              border-radius: 5px;
          }
          i.color_dropdown {
              height: 15px;
          }
        .maroon {
            background: #b21f24;
        }
        .dodger_blue {
            background: #6055ff;
        }
        .vermilion {
            background: #ff4416;
        }
        .jungle_green {
            background: #28B463;
        }



  /* .logo-preview{
    width:100% !important;
    height:auto !important;
  } */

  @media only screen and (max-width: 700px){
    .image-upload-container{
      grid-template-areas: 'img-u-one img-u-two img-u-three'
       'img-u-four img-u-five img-u-six';
    }
  }

    </style>
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        {{-- <a href="" class="btn btn-info">{{ __('dashboard.btn_refresh') }}</a> --}}
                    </div>
                </div>
                <input type="hidden" name="store_id" id="store_id"
                       value="{{ !empty($stores->id) ? $stores->id : '' }}">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Setting</h4>
                                <br />

                                <ul class="nav nav-tabs mb-3">

                                    {{-- <li class="nav-item">
                                    <a href="#domain-tab" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        Domain
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#subdomain-tab" data-toggle="tab" aria-expanded="false" class="nav-link">
                                        Sub Domain
                                    </a>
                                </li> --}}
                                    <li class="nav-item">
                                        <a href="#website-tab" data-toggle="tab" aria-expanded="false"
                                            class="nav-link active">
                                            Store Info
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="#social-tab" data-toggle="tab" aria-expanded="true" class="nav-link">
                                            Social Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#address-tab" data-toggle="tab" aria-expanded="true"
                                            class="nav-link">
                                            Address Info
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#store-tab" data-toggle="tab" aria-expanded="true" class="nav-link">
                                            Pannel Setting
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#pages-tab" data-toggle="tab" aria-expanded="true" class="nav-link">
                                            Store Pages
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#theme-tab" data-toggle="tab" aria-expanded="true" class="nav-link">
                                            Theme Setting
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane" id="store-tab">

                                        <!-- Form Start -->
                                        <form id="addStorePannelSetting">
                                            @csrf
                                            <input type="hidden" name="store_id" class="store_id" value="{{ !empty($stores->id) ? $stores->id : -1 }}">
                                            <div class="form-group">
                                                <label for="title">Store Link: <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                   @if(Auth::user()->type == 'shop')
                                                        <input type="text" value="{{ (!empty($storeSettings->store_link) ? $storeSettings->store_link : '') }}" name="store_link" id="store_link" class="form-control" readonly >
                                                    @else
                                                        <input type="text" value="{{ (!empty($storeSettings->store_link) ? $storeSettings->store_link : '') }}" name="store_link" id="store_link" class="form-control" >
                                                    @endif
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-primary" type="button" onclick="myFunction()" id="button-addon2"><i class="far fa-copy"></i> Copy Link</button>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback">
                                                    {{ __('dashboard.please_provide') }}
                                                    {{ __('dashboard.site_title') }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" id="btn_save_pannel" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                        <!-- Form End -->

                                    </div>
                                    <div class="tab-pane" id="pages-tab">

                                        <!-- Form Start -->
                                        <form id="addStorPages">
                                            @csrf
                                            <div class="form-group col-lg-12">
                                                <label>About Us<span class="text-danger">*</span></label>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <textarea class="summernote" name="about"  id="summernote">@if(!empty($storeSettings->about_us)){!!json_decode($storeSettings->about_us)!!}@endif</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label>Terms & Condition<span class="text-danger">*</span></label>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <textarea class="summernote" name="terms"  id="summernote">@if(!empty($storeSettings->terms_condition)){!!json_decode($storeSettings->terms_condition)!!}@endif</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label>Returns & Exchanges<span class="text-danger">*</span></label>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <textarea class="summernote" name="returns"  id="summernote">@if(!empty($storeSettings->returns_exchange)){!!json_decode($storeSettings->returns_exchange)!!}@endif</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label>Shipping & Delivery<span class="text-danger">*</span></label>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <textarea class="summernote" name="shiping" id="summernote">@if(!empty($storeSettings->shipping_delivery)){!!json_decode($storeSettings->shipping_delivery)!!}@endif</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label>Privacy & Policy<span class="text-danger">*</span></label>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <textarea class="summernote" name="privacy"  id="summernote">@if(!empty($storeSettings->privacy_policy)){!!json_decode($storeSettings->privacy_policy)!!}@endif</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="button" id="btn_save_pages" class="btn btn-primary">Update</button>
                                            </div>



                                        </form>
                                        <!-- Form End -->

                                    </div>

                                    <div class="tab-pane" id="theme-tab">
                                        <!-- Form Start -->
                                        <form id="addStoreTheme">
                                            @csrf
                                            <input type="hidden" name="store_id" id="store_id" value="{{ !empty($stores->id) ? $stores->id : '' }}">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label>Select Theme<span class="text-danger">*</span></label>
                                                    <select class="form-control selectpicker" name="theme" data-live-search="true"  >
                                                        @foreach($themes as $index => $name)
                                                            <option value="{{ $index }}" {{ ((isset($storeSettings->theme) && $storeSettings->theme == $index) ? 'selected' : '') }} >{{ $name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label>Select Color<span class="text-danger">*</span></label>
                                                    <select class="form-control selectpicker" name="theme_color" data-live-search="true" >
                                                        @foreach($themeColors['default'] as $colorArr)
                                                            <option value="{{ $colorArr['class'] }}" {{ ((isset($storeSettings->theme_color) && $storeSettings->theme_color == $colorArr['class']) ? 'selected' : '') }} data-color_code="{{ $colorArr['hex'] }}" data-icon="color_dropdown {{ $colorArr['class'] }}">{{ $colorArr['name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" id="btn_save_theme" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- Form End -->

                                    </div>

                                    <div class="tab-pane show active" id="website-tab">

                                        <!-- Form Start -->
                                        <form class="needs-validation" novalidate id="addStoreInfo">
                                            @csrf
                                            <input name="id" type="hidden" value="">

                                            <div class="form-group">
                                                <label for="title">Store Name: <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="title" id="title"
                                                    value="{{ !empty($stores->name) ? $stores->name : '' }}"
                                                    required>

                                                <div class="invalid-feedback">
                                                    {{ __('dashboard.please_provide') }}
                                                    {{ __('dashboard.site_title') }}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="description">Meta Description: <span></span></label>
                                                <textarea class="form-control" name="description" id="description"
                                                    rows="4">{{ !empty($storeSettings->description) ? $storeSettings->description : '' }}</textarea>

                                                <div class="invalid-feedback">
                                                    {{ __('dashboard.please_provide') }}
                                                    {{ __('dashboard.meta_description') }}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="keywords">Meta Keywords: <span></span></label>
                                                <textarea class="form-control" name="keywords" id="keywords"
                                                    rows="4">{{ !empty($storeSettings->keywords) ? $storeSettings->keywords : '' }}</textarea>

                                                <div class="invalid-feedback">
                                                    {{ __('dashboard.please_provide') }}
                                                    {{ __('dashboard.meta_keywords') }}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">

                                                    @if (isset($storeSettings->logo_path))
                                                        @if (is_file($storeSettings->logo_path))
                                                            <img src="{{ asset($storeSettings->logo_path) }}"
                                                                class="img-fluid img_pre site-image"
                                                                alt="{{ __('dashboard.site_logo') }}">
                                                        @endif
                                                    @endif
                                                    </br>
                                                    <label for="logo">Store Logo: <span
                                                            class="text-danger">*</span></label>
                                                    <input type="file" class="form-control" name="logo" id="logo">


                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.site_logo') }}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    @if (isset($storeSettings->favicon_path))
                                                        @if (is_file($storeSettings->favicon_path))
                                                            <img src="{{ asset($storeSettings->favicon_path) }}"
                                                                class="img-fluid img_pre site-image"
                                                                alt="{{ __('dashboard.site_logo') }}">
                                                        @endif
                                                    @endif
                                                    </br>
                                                    <input type="hidden" name="id" class="id"
                                                        value="{{ !empty($storeSettings->id) ? $storeSettings->id : -1 }}">
                                                    <input type="hidden" name="store_id" id="store_id"
                                                        value="{{ !empty($stores->id) ? $stores->id : '' }}">
                                                    <label for="favicon">Store favicon: <span
                                                            class="text-danger">*</span></label>

                                                    <!-- Image Preview : Start  -->
                                                                    <input type="file" class="form-control" name="favicon" id="file-ip-1">
                                                            <div class="invalid-feedback">
                                                                {{ __('dashboard.please_provide') }}
                                                                {{ __('dashboard.site_logo') }}
                                                            </div>
                                                        {{--<input type="file"  name="favicon" id="file-ip-1" accept="image/*" onchange="showPreview(event, 1);">--}}

                                                    <!-- Image Preview : End  -->
                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.site_favicon') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-md-6 form-group">
                                                <label for="bannertitle">Banner Title</label>
                                                <input type="text" name="banner_title" id="banner_title" class="form-control" value="{{ !empty($storeSettings->banner_title) ? $storeSettings->banner_title : '' }}">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                <label for="bannertitle">Banner Images <span class="text-danger">*</span>  <span>(You can upload multiple images)</span></label>
                                                @php
                                                    if(!empty($storeSettings->cover_images)){
                                                        $coverImages = [];
                                                        foreach ($storeSettings->cover_images as $key => $imgObj) {
                                                          $coverImages[] = [
                                                             'id' =>$imgObj->id,
                                                             'src'=>  asset($imgObj->image)
                                                          ];
                                                        }
                                                      }
                                                    @endphp
                                                    <div class="input-images"></div>


                                                </div>
                                                <div class="col-md-6 form-group">
                                                <label for="bannertitle">Banner Description</label>
                                               <textarea name="banner_description" id="banner_description" cols="30" rows="10" class="form-control">{{ !empty($storeSettings->banner_description) ? $storeSettings->banner_description : '' }}</textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    @if (isset($storeSettings->cart_image))
                                                        @if (is_file($storeSettings->cart_image))
                                                            <img src="{{ asset($storeSettings->cart_image) }}"
                                                                class="img-fluid img_pre site-image"
                                                                alt="{{ __('dashboard.site_logo') }}">
                                                        @endif
                                                    @endif
                                                    </br>
                                                    <label for="cart_image">Cart Page Cover Image: </label>
                                                    <input type="file" class="form-control" name="cart_image" id="cart_image" required>

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.site_logo') }}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">

                                                    @if (isset($storeSettings->wishlist_image))
                                                        @if (is_file($storeSettings->wishlist_image))
                                                            <img src="{{ asset($storeSettings->wishlist_image) }}"
                                                                class="img-fluid img_pre  site-image"
                                                                alt="{{ __('dashboard.site_logo') }}">
                                                        @endif
                                                    @endif
                                                    </br>
                                                    <label for="wishlist_image">WishList Page Cover Image:</label>
                                                    <input type="file" class="form-control" name="wishlist_image" id="wishlist_image" required>

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.site_logo') }}
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">

                                                    @if (isset($storeSettings->products_cover_image))
                                                        @if (is_file($storeSettings->products_cover_image))
                                                            <img src="{{ asset($storeSettings->products_cover_image) }}"
                                                                class="img-fluid img_pre site-image"
                                                                alt="{{ __('dashboard.site_logo') }}">
                                                        @endif
                                                    @endif
                                                    </br>
                                                    <label for="wishlist_image">Product Page Cover Image:</label>
                                                    <input type="file" class="form-control" name="products_cover_image" id="products_cover_image" required>

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.site_logo') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4">
                                                <label for="footer_text">Footer Text: <span
                                                        class="text-danger">*</span></label>
                                                <textarea class="form-control" name="footer_text" id="footer_text"
                                                    rows="2"
                                                    required>{{ !empty($storeSettings->footer_text) ? $storeSettings->footer_text : '' }}</textarea>

                                                <div class="invalid-feedback">
                                                    {{ __('dashboard.please_provide') }}
                                                    {{ __('dashboard.footer_text') }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" id="btn_save_store_info"
                                                    class="btn btn-primary">Update</button>
                                            </div>

                                        </form>
                                        <!-- Form End -->

                                    </div>
                                    <div class="tab-pane" id="address-tab">

                                        <!-- Form Start -->
                                        <form id="addAddressInfo">
                                            @csrf
                                            <input name="id" type="hidden" class="id"
                                                value="{{ isset($storeSettings->id) ? $storeSettings->id : -1 }}">
                                            <input type="hidden" name="store_id" id="store_id"
                                                value="{{ !empty($stores->id) ? $stores->id : '' }}">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="phone_no">Tagline <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="tagline" id="tagline"
                                                        value="{{ !empty($storeSettings->tagline) ? $storeSettings->tagline : '' }}"
                                                        required>

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.phone_no_1') }}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="address">Address:</label>
                                                    <input type="text" class="form-control" name="address" id="address"
                                                        value="{{ !empty($storeSettings->address) ? $storeSettings->address : '' }}">

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.phone_no_2') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="country">Country:<span class="text-danger">*</span></label>
                                                    <select name="country" id="countryId" class="form-control countries pt--10 pb--10 pr-2 pl-2 mb--10">
                                                        <option value="">Select Country*</option>
                                                        @if(!empty($storeSettings->country))
                                                            <option selected value="{{ !empty($storeSettings->country) ? $storeSettings->country : '' }}">{{$storeSettings->country}}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                {{--<div class="form-group col-md-6">
                                                    <label for="country">Country: <span class="text-danger">*</span></label>
                                                     <input type="text" class="form-control" name="country" id="country" value="{{ !empty($storeSettings->country) ? $storeSettings->country : '' }}" required>
                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.contact_mail') }}
                                                    </div>
                                                </div>--}}
                                                <div class="form-group col-md-6">
                                                    <label for="state">State:<span class="text-danger">*</span></label>
                                                    <select name="state" class="form-control states pt--10 pb--10 pr-2 pl-2 mb--10" id="stateId">
                                                        @if(!empty($storeSettings->state))
                                                            <option value="{{ !empty($storeSettings->state) ? $storeSettings->state : '' }}">{{$storeSettings->state}}</option>
                                                        @else
                                                            <option value="">Select State</option>
                                                        @endif
                                                    </select>
                                                    {{--<input type="text" class="form-control" name="state" id="state"
                                                        value="{{ !empty($storeSettings->state) ? $storeSettings->state : '' }}">

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.email_address_2') }}
                                                    </div>--}}
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="city">City: <span class="text-danger">*</span></label>
                                                    <select name="city" class="form-control cities pt--10 pb--10 pr-2 pl-2 mb--10"  id="cityId">
                                                        @if(!empty($storeSettings->city))
                                                        <option value="{{ !empty($storeSettings->city) ? $storeSettings->city : '' }}">{{$storeSettings->city}}</option>
                                                        @else
                                                            <option value="">Select City</option>
                                                        @endif
                                                    </select>
                                                    {{--<input type="text" class="form-control" name="city" id="city"
                                                           value="{{ !empty($storeSettings->city) ? $storeSettings->city : '' }}"
                                                           required>

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.email_address_1') }}
                                                    </div>--}}
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="zipcode">Zip Code: <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="zip_code" id="zip_code"
                                                           value="{{ !empty($storeSettings->zip_code) ? $storeSettings->zip_code : '' }}"
                                                           required>

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.contact_address') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <button type="button" id="btn_save_address_detail"
                                                    class="btn btn-primary">Update</button>
                                            </div>

                                        </form>
                                        <!-- Form End -->

                                    </div>
                                    <div class="tab-pane" id="social-tab">

                                        <!-- Form Start -->
                                        <form class="needs-validation" id="addSocailInfo">
                                            @csrf
                                            <input name="id" type="hidden" class="id"
                                                value="{{ isset($storeSettings->id) ? $storeSettings->id : -1 }}">
                                            <input type="hidden" name="store_id" id="store_id"
                                                value="{{ !empty($stores->id) ? $stores->id : '' }}">

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="email">Email:<span class="text-danger">*</span></label>
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        value="{{ !empty($storeSettings->email) ? $storeSettings->email : '' }}">

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.facebook') }}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="whtsapp">Whatsapp</label>
                                                    <input type="number" class="form-control" name="whatsapp" id="whatsapp"
                                                        value="{{ !empty($storeSettings->whatsapp) ? $storeSettings->whatsapp : '' }}">

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.twitter') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="Facebook">Facebook</label>
                                                    <input type="url" class="form-control" name="facebook" id="facebook"
                                                        value="{{ !empty($storeSettings->facebook) ? $storeSettings->facebook : '' }}">

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.linkedin') }}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="instagram">Instagram</label>
                                                    <input type="url" class="form-control" name="instagram"
                                                        id="instagram"
                                                        value="{{ !empty($storeSettings->instagram) ? $storeSettings->instagram : '' }}">

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.instagram') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="twitter">Twitter</label>
                                                    <input type="url" class="form-control" name="twitter" id="twitter"
                                                        value="{{ !empty($storeSettings->twitter) ? $storeSettings->twitter : '' }}">

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.pinterest') }}
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="youtube">Youtube</label>
                                                    <input type="url" class="form-control" name="youtube" id="youtube"
                                                        value="{{ !empty($storeSettings->youtube) ? $storeSettings->youtube : '' }}">

                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.youtube') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <input type="hidden" class="form-control" name="country_short_name" id="country_short_name" value="" />
                                                <div class="form-group col-md-6">
                                                    <label for="skype">Phone Number</label>
                                                    <input type="text" class="form-control" name="phone_no"
                                                        id="phone_no"
                                                        value="{{ !empty($storeSettings->phone_no)? $storeSettings->phone_no : ''  }}">
                                                    <div class="invalid-feedback">
                                                        {{ __('dashboard.please_provide') }}
                                                        {{ __('dashboard.skype') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" id="btn_save_social_info"
                                                    class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                        <!-- Form End -->
                                    </div>
                                    <div class="tab-pane" id="subdomain-tab">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input class="form-control" placeholder="Enter Domain" readonly=""
                                                    name="subdomain" id="sub_domain" type="text" value="premium-blinds">
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="basic-addon2">.subdomain.com</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{-- <button type="button" id="btn_save_pannel" class="btn btn-primary">Update</button> --}}
                                        </div>

                                    </div>
                                    <div class="tab-pane" id="assing-products">

                                        <!-- Form Start -->
                                        <form id="assignProductForm">
                                            @csrf
                                            <input type="hidden" name="id" class="id"
                                                value="{{ !empty($storeSettings->id) ? $storeSettings->id : -1 }}">
                                            <input type="hidden" name="store_id" id="store_id"
                                                value="{{ !empty($stores->id) ? $stores->id : '' }}">

                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    {{-- <h6 class="text-dark">Setting</h6> --}}
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="col-form-label">Contract</label>
                                                    <select class="form-control" name="contract_id[]" id="contract_id" >
                                                        @if (!empty($contracts))
                                                            @foreach ($contracts as $obj)
                                                                <option value="{{ $obj->id }}">{{ $obj->name }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="col-12 mt-3">
                                                    <div class="form-group">
                                                        <button type="button" id="btn_save_product"
                                                            class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                        <!-- Form End -->
                                    </div>
                                </div>
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
@endsection

@section('page_level_js_plugins')
    <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js?v=7.0.4') }}"></script>
    <script src="{{ asset ('assets/dist/image-uploader.min.js') }}"></script>
    <script src="{{ asset ('assets/js/pages/crud/forms/editors/summernote.js?v=7.0.4') }}"></script>
     {{-- <script src="{{asset('assets/libs/dropzone/dist/min/dropzone.min.js')}}"></script> --}}
    <script src="{{ asset('assets/plugins/custom/jqvalidation/jquery.validate.min.js?v=7.0.4') }}"></script>

@endsection

@section('page_level_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.min.js"></script>
    <script src="{{ asset('assets/plugins/custom/multiselect/multi-select.js?v=7.0.4') }}"></script>
    <script src="{{ asset('assets/plugins/custom/multiselect/quicksearch/quicksearch.js?v=7.0.4') }}"></script>
    <script src="{{ asset('front/js/countrystatecity.js') }}"></script>
    <script type="text/javascript">

        jQuery(document).ready(function() {
            @if(!empty($storeSettings->country_short_name) && !empty($storeSettings->phone_no))
                var countryCode = "{{$storeSettings->country_short_name}}";
                $("#phone_no").intlTelInput("setCountry", countryCode);
                $("#phone_no").val("{{$storeSettings->phone_no}}");
            @endif
            // datatable.init();
            var id = $('.image-uploader').find('input').addClass('cover-images');
            var validator = $("#addStoreInfo").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    title: {
                        required: true
                    },
                    logo: {
                        required: true
                    },
                    favicon: {
                        required: true
                    },
                    footer_text: {
                        required: true
                    },
                    'images[]':{
                        required:true
                    },
                    cart_image:{
                        required:true
                    },
                    wishlist_image:{
                        required:true
                    },
                    products_cover_image:{
                        required:true
                    },
                },
                errorPlacement: function(error, element) {
                    var elem = $(element);
                    if (elem.hasClass("selectpicker") ||  elem.hasClass("cover-images")) {
                        element = elem.parent();
                        error.insertAfter(element);
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            var validator = $("#addSocailInfo").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    email: {
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
            var validator = $("#addAddressInfo").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    tagline: {
                        required: true
                    },
                    city: {
                        required: true
                    },
                    zip_code: {
                        required: true
                    },
                    country: {
                        required: true
                    },
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
            $("#addStoreTheme").validate({
                ignore: ":hidden:not(.selectpicker)",
                rules: {
                    theme: {
                        required: true
                    },
                    theme_color: {
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

            $(document).on('click', '#btn_save_address_detail', function() {

                var validate = $("#addAddressInfo").valid();
                if (validate) {
                    //var form_data = $("#addForm").serializeArray();
                    var form = $('#addAddressInfo')[0];
                    var form_data = new FormData(form);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('setting.addressInfo') }}", // your php file name
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

                                $('#add_edit_modal').modal('hide');
                                $('.id').val('');
                                $('.id').val(data.id);

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
            $(document).on('click', '#btn_save_social_info', function() {
                var country_short_code = $('.iti__selected-dial-code').html();
                var validate = $("#addSocailInfo").valid();
                if (validate) {
                    //var form_data = $("#addForm").serializeArray();
                    var form = $('#addSocailInfo')[0];
                    var form_data = new FormData(form);
                    form_data.append('country_short_code', country_short_code);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('setting.socialinfo') }}", // your php file name
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

                                $('#add_edit_modal').modal('hide');
                                $('.id').val('');

                                $('.id').val(data.id);

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
            $(document).on('click', '#btn_save_pannel', function() {

                var validate = $("#addStorePannelSetting").valid();
                if (validate) {
                    //var form_data = $("#addForm").serializeArray();
                    var form = $('#addStorePannelSetting')[0];
                    var form_data = new FormData(form);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('setting.panelInfo') }}", // your php file name
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

                                $('#add_edit_modal').modal('hide');
                                $('.id').val('');

                                $('.id').val(data.id);

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
            $(document).on('click', '#btn_save_store_info', function() {
                var id = $('.id').val();
                if (id != -1) {
                    $('#logo').rules('add', {
                        required: false // overwrite an existing rule
                    });
                    $('#favicon').rules('add', {
                        required: false // overwrite an existing rule
                    });
                    $('.cover-images').rules('add', {
                        required: false // overwrite an existing rule
                    });
                    $('#cart_image').rules('add', {
                        required: false // overwrite an existing rule
                    });
                    $('#wishlist_image').rules('add', {
                        required: false // overwrite an existing rule
                    });
                    $('#products_cover_image').rules('add', {
                        required: false // overwrite an existing rule
                    });
                }
                var validate = $("#addStoreInfo").valid();
                if (validate) {
                    //var form_data = $("#addForm").serializeArray();
                    var form = $('#addStoreInfo')[0];
                    var form_data = new FormData(form);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('setting.siteinfo') }}", // your php file name
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
                                $('#add_edit_modal').modal('hide');
                                $('.id').val('');
                                $('.id').val(data.id);
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
            $(document).on('click', '#btn_save_pages', function() {
                var id = $('#store_id').val();
                var validate = $("#addStorPages").valid();
                if (validate) {
                    //var form_data = $("#addForm").serializeArray();
                    var form = $('#addStorPages')[0];
                    var form_data = new FormData(form);
                    form_data.append('id', id);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('setting.sitepages') }}", // your php file name
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
                                $('#add_edit_modal').modal('hide');
                                $('.id').val('');
                                $('.id').val(data.id);
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
            $(document).on('click', '#btn_save_theme', function() {
                var validate = $("#addStoreTheme").valid();
                if (validate) {
                    var form = $('#addStoreTheme')[0];
                    var form_data = new FormData(form);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('setting.sitetheme') }}", // your php file name
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
                                $('#add_edit_modal').modal('hide');
                                $('.id').val('');
                                $('.id').val(data.id);
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


        });


        function resetForm() {
            $('#addForm')[0].reset();
            $('#id').val("");
            $('#branch_id').val("").trigger('change').selectpicker('refresh');
        }

        $('#contract_id').multiSelect({
            selectableHeader: "<input type='text' class='form-control multiselect_search_input search-input' autocomplete='off' placeholder='Type to search'/>",
            selectionHeader: "<input type='text' class='form-control multiselect_search_input search-input' autocomplete='off' placeholder='Type to search'/>",
            selectableFooter: "<a href='javscript:;' id='product_select_all' class='btn btn-primary btn_multiselect_search_option'>select all</a>",
            selectionFooter: "<a href='javscript:;' id='product_deselect_all' class='btn btn-primary btn_multiselect_search_option'>deselect all</a>",
            afterInit: function(ms) {
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#' + that.$container.attr('id') +
                    ' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#' + that.$container.attr('id') +
                    ' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function(e) {
                        if (e.which === 40) {
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function(e) {
                        if (e.which == 40) {
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
            },
            afterSelect: function() {
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function() {
                this.qs1.cache();
                this.qs2.cache();
            }
        });
        $('#product_select_all').click(function() {
            $('#contract_id').multiSelect('select_all');
            return false;
        });
        $('#product_deselect_all').click(function() {
            $('#contract_id').multiSelect('deselect_all');
            return false;
        });


        function myFunction() {
            var copyText = document.getElementById("store_link");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
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
            toastr.success('Link copied');
        }

        @if(!empty($storeSettings->cover_images))

        var images = <?php echo json_encode($coverImages); ?>;// don't use quotes
        //console.log(images);
        $('.input-images').imageUploader({
            preloaded:images
        });
        @else
        $('.input-images').imageUploader({
            imagesInputName: 'images',
            //preloadedInputName: 'preloaded',
            label: 'Drag & Drop files here or click to browse'
        });
        @endif

        $(".delete-image").on('click', function () {
            var id = $(this).closest('.uploaded-image').find('input').val();
            var form_data = new FormData();
            form_data.append('id', id);
            $.ajax({
                type: "POST",
                url: "{{route('removeCoverImage')}}", // your php file name
                data: form_data,
                dataType: "json",
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data){
                    if(data.status == 'success') {

                    } else {

                    }
                },
                error: function (errorString){
                    alert('contact to admin');
                }
            });
        });

        var number = 1;
        do {
        function showPreview(event, number){
            if(event.target.files.length > 0){
            let src = URL.createObjectURL(event.target.files[0]);
            let preview = document.getElementById("file-ip-"+number+"-preview");
            preview.src = src;
            preview.style.display = "block";
            }
        }
        function myImgRemove(number) {
            document.getElementById("file-ip-"+number+"-preview").src = "https://i.ibb.co/ZVFsg37/default.png";
            document.getElementById("file-ip-"+number).value = null;
            }
        number++;
        }
        while (number < 5);

        function validate() {

            var number = $("#phone_no").intlTelInput('getNumber');
            iso = $("#phone_no").intlTelInput('getSelectedCountryData').iso2;
            var exampleNumber = intlTelInputUtils.getExampleNumber(iso, 0, 0);
            if (number == '')
                number = exampleNumber;

            var formattedNumber = intlTelInputUtils.formatNumber(number, iso, intlTelInputUtils.numberFormat.NATIONAL);
            var isValidNumber = intlTelInputUtils.isValidNumber(number, iso);
            var validationError = intlTelInputUtils.getValidationError(number, iso);
        }
        $("#phone_no").intlTelInput({
            geoIpLookup: function(callback) {
                $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);

                });
            },
            initialCountry: "auto",
            separateDialCode: true,
        });
        $('#phone_no').on('countrychange', function(e) {
            $(this).val('');
            var selectedCountryCode = $(this).intlTelInput('getSelectedCountryData').iso2;
            var selectedCountry = $(this).intlTelInput('getSelectedCountryData');
            var dialCode = selectedCountry.dialCode;
            var maskNumber = intlTelInputUtils.getExampleNumber(selectedCountry.iso2, 0, 0);
           // console.log("placeholder > " + maskNumber);
            maskNumber = intlTelInputUtils.formatNumber(maskNumber, selectedCountry.iso2, 2);
            //console.log("placeholder > " + maskNumber);
            maskNumber = maskNumber.replace('+' + dialCode + ' ', '');
            //console.log("placeholder > " + maskNumber);
            mask = maskNumber.replace(/[0-9+]/ig, '0');
            $("#country_short_name").val(selectedCountryCode);

            $('#phone_no').mask(mask, {
                placeholder: maskNumber
            });
        });
        $(document).ready(function() {
          if (window.File && window.FileList && window.FileReader) {
            $("#logo").on("change", function(e) {
              var files = e.target.files,
                filesLength = files.length;
              for (var i = 0; i < filesLength; i++) {
                var f = files[i]
                var fileReader = new FileReader();
                fileReader.onload = (function(e) {
                  var file = e.target;
                  $("<span class=\"pip\">" +
                    "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                    "<br/><span class=\"remove\">Remove image</span>" +
                    "</span>").insertAfter("#logo");
                  $(".remove").click(function(){
                    $(this).parent(".pip").remove();
                  });
                });
                fileReader.readAsDataURL(f);
              }
            });
          } else {
            alert("Your browser doesn't support to File API")
          }
        });
    $(document).ready(function() {
      if (window.File && window.FileList && window.FileReader) {
        $("#file-ip-1").on("change", function(e) {
          var files = e.target.files,
            filesLength = files.length;
          for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();
            fileReader.onload = (function(e) {
              var file = e.target;
              $("<span class=\"pip\">" +
                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                "<br/><span class=\"remove\">Remove image</span>" +
                "</span>").insertAfter("#file-ip-1");
              $(".remove").click(function(){
                $(this).parent(".pip").remove();
              });
            });
            fileReader.readAsDataURL(f);
          }
        });
      } else {
        alert("Your browser doesn't support to File API")
      }
    });
    $(document).ready(function() {
      if (window.File && window.FileList && window.FileReader) {
        $("#cart_image").on("change", function(e) {
          var files = e.target.files,
            filesLength = files.length;
          for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();
            fileReader.onload = (function(e) {
              var file = e.target;
              $("<span class=\"pip\">" +
                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                "<br/><span class=\"remove\">Remove image</span>" +
                "</span>").insertAfter("#cart_image");
              $(".remove").click(function(){
                $(this).parent(".pip").remove();
              });
            });
            fileReader.readAsDataURL(f);
          }
        });
      } else {
        alert("Your browser doesn't support to File API")
      }
    });
    $(document).ready(function() {
      if (window.File && window.FileList && window.FileReader) {
        $("#wishlist_image").on("change", function(e) {
          var files = e.target.files,
            filesLength = files.length;
          for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();
            fileReader.onload = (function(e) {
              var file = e.target;
              $("<span class=\"pip\">" +
                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                "<br/><span class=\"remove\">Remove image</span>" +
                "</span>").insertAfter("#wishlist_image");
              $(".remove").click(function(){
                $(this).parent(".pip").remove();
              });
            });
            fileReader.readAsDataURL(f);
          }
        });
      } else {
        alert("Your browser doesn't support to File API")
      }
    });
    $(document).ready(function() {
      if (window.File && window.FileList && window.FileReader) {
        $("#products_cover_image").on("change", function(e) {
          var files = e.target.files,
            filesLength = files.length;
          for (var i = 0; i < filesLength; i++) {
            var f = files[i]
            var fileReader = new FileReader();
            fileReader.onload = (function(e) {
              var file = e.target;
              $("<span class=\"pip\">" +
                "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                "<br/><span class=\"remove\">Remove image</span>" +
                "</span>").insertAfter("#products_cover_image");
              $(".remove").click(function(){
                $(this).parent(".pip").remove();
              });
            });
            fileReader.readAsDataURL(f);
          }
        });
      } else {
        alert("Your browser doesn't support to File API")
      }
    });
    </script>
@endsection

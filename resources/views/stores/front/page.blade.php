@extends('layouts.template')

@section('title', 'Home')
@section('description', 'Home Description')

@section('page_level_css')
@endsection

@section('content')
        @if(!empty($storeSetting->products_cover_image))
    <div class="ht__bradcaump__area"style="background: rgba(0, 0, 0, 0)
             url({{asset($storeSetting->products_cover_image)}}) no-repeat scroll
             center center / cover ;">
        @else
            <div class="ht__bradcaump__area"style="background: rgba(0, 0, 0, 0)
                url({{asset('front/images/bg/default-img-bradcaump-bg-1920x320.jpg')}}) no-repeat scroll
                center center / cover ;">
                @endif
        <div class="ht__bradcaump__wrap">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="bradcaump__inner text-center">
                            <h2 class="bradcaump-title">{{str_replace("_"," ",ucfirst($pageName))}}</h2>
                            <nav class="bradcaump-inner">
                                <a class="breadcrumb-item link-primary" href="index.html">Home</a>
                                <span class="brd-separetor">/</span>
                                <span class="breadcrumb-item active">{{str_replace("_"," ",ucfirst($pageName))}} Page</span>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Contact Area -->
    <section class="htc__contact__area ptb--120 bg__white">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <div class="container body content">
                        <p>
                            @if(!empty($pageinfo->$pageName)){!!json_decode($pageinfo->$pageName)!!}@endif
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- End Contact Area -->


@endsection
@section('page_level_js')

    <script src="{{ asset('front/js/plugins.js') }}"></script>
@endsection

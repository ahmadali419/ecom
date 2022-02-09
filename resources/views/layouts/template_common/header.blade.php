<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div class="container top-bar-note-web">
    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-3 col-xs-3">
            <div class="logo header-logo-cust mt--20 mb--20">
                @if(isset($storeSetting->slug) && !empty($storeSetting->logo_path))
                <a href="{{  url('/') }}">
                    <img src="{{ asset($storeSetting->logo_path)}}" alt="logo">
                </a>
                @else
                    <a href="{{  url('/') }}">
                        <img src="{{ asset('front/images/slider/bg/logo-img-113x27.jpg') }}" alt="logo">
                    </a>
                @endif
            </div>
        </div>
        <!-- Start MAinmenu Ares -->
        <div class="col-md-3 col-lg-2 hidden-sm hidden-xs">
            <div class="mt--30">
                <h3 class="h7-heading f-bold-5 text-primary"><i class="ti-mobile icon-size-7 mr-2"></i>Phone</h3>
                <p class="text-primary ml-6">{{isset($storeSetting->slug) && !empty($storeSetting->phone_no) ? $storeSetting->phone_no:''}}</p>
            </div>
        </div>
        <div class="col-md-3 col-lg-2 hidden-sm hidden-xs">
            <div class="mt--30">
                <h3 class="h7-heading f-bold-5 text-primary"><i class="ti-email icon-size-7 mr-2"></i>Email</h3>
                <p class="text-primary ml-6">{{isset($storeSetting->slug) && !empty($storeSetting->email) ? $storeSetting->email:''}}</p>
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-7 hidden-xs float-left-style">
            <div class="mt--30">
                @if(Auth::check())
                <a href="{{route('costomerlogout')}}"><h3 class="h7-heading f-bold-5 text-primary hidden-sm hidden-xs"><i class="ti-user  border-bolder border-1 padding-1 icon-size-9 f-bold-6" ></i> Logout</h3></a>
                @else
                    <a href="{{route('login')}}"><h3 class="h7-heading f-bold-5 text-primary hidden-sm hidden-xs"><i class="ti-user  border-bolder border-1 padding-1 icon-size-9 f-bold-6" ></i> Login</h3></a>
                @endif
            </div>
        </div>
    </div>
</div>

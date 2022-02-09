<footer class="htc__foooter__area gray-bg margin-0" style="background-image: url('../images/bg/footer-sec.png')">
    <div class="container">
        <div class="row">
            <div class="footer__container clearfix">
                <!-- Start Single Footer Widget -->
                <div class="col-md-6 col-lg-6 col-sm-6">
                    <div class="ft__widget">
                        <div class="ft__logo">
                            @if(isset($store->slug) && !empty($storeSetting->logo_path))
                                <a href="{{url('') }}{{'/store/'.$storeSetting->slug}}">
                                    <img src="{{ asset($storeSetting->logo_path)}}" alt="logo">
                                </a>
                            @else
                            <a href="{{  url('') }}{{'/store/'.$storeSetting->slug}}">
                                <img src="{{ asset('front/images/slider/bg/logo-img-113x27.jpg') }}" alt="footer logo">
                            </a>
                            @endif
                        </div>
                        <div class="footer-address">
                            <ul>
                                <li>
                                    <div class="address-icon">
                                        <i class="zmdi zmdi-pin"></i>
                                    </div>
                                    <div class="address-text">
                                        <p>{{isset($storeSetting->slug) && !empty($storeSetting->address) ? $storeSetting->address:''}}</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="address-icon">
                                        <i class="zmdi zmdi-email"></i>
                                    </div>
                                    <div class="address-text">
                                        <a class="text-white link-text-glow" href="#">{{isset($store->slug) && !empty($storeSetting->email) ? $storeSetting->email:''}}</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="address-icon">
                                        <i class="zmdi zmdi-phone-in-talk"></i>
                                    </div>
                                    <div class="address-text">
                                        <p>{{isset($store->slug) && !empty($storeSetting->phone_no) ? $storeSetting->phone_no:''}}</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <ul class="social__icon">
                            <li><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                            <li><a href="#"><i class="zmdi zmdi-instagram"></i></a></li>
                            <li><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                            <li><a href="#"><i class="zmdi zmdi-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Single Footer Widget -->
                <!-- Start Single Footer Widget -->
                <div class="col-md-6 col-lg-6 col-sm-12 smt-30 xmt-30 custom-footer-links">
                    <div class="row">

                        <div class="col-md-6 col-lg-6 col-sm-6">
                            <div class="ft__widget">
                                <h2 class="ft__title">Categories</h2>
                                <ul class="footer-categories">
                                    @if(!$storeProductCategory->isEmpty())
                                    @foreach($storeProductCategory as $storeCatObj)
                                            @if(isset($store->slug) && !empty($store->slug))
                                                <li><a href="{{route('store.categorie.product',[$store->slug,$storeCatObj->id])}}" class="text-white link-text-glow">{{ucfirst($storeCatObj->name)}}</a></li>
                                            @else
                                        <li><a href="{{route('getProductByCategory',$storeCatObj->id)}}" class="text-white link-text-glow">{{ucfirst($storeCatObj->name)}}</a></li>
                                            @endif
                                    @endforeach
                                @endif
                                </ul>
                            </div>
                        </div>
                        <!-- Start Single Footer Widget -->
                        <div class="col-md-6 col-lg-6 col-sm-6">
                            <div class="ft__widget">
                                <h2 class="ft__title">Infomation</h2>
                                <ul class="footer-categories">

                                    <li><a href="{{isset($store->slug) && !empty($store->slug) ? url('store/'.$store->slug.'/about_us') : ''}}" class="text-white link-text-glow">About Us</a></li>
                                    <li><a href="#" class="text-white link-text-glow">Contact Us</a></li>
                                    <li><a href="{{isset($store->slug) && !empty($store->slug) ? url('store/'.$store->slug.'/terms_condition') : ''}}" class="text-white link-text-glow">Terms & Conditions</a></li>
                                    <li><a href="{{isset($store->slug) && !empty($store->slug) ? url('store/'.$store->slug.'/returns_exchange') : ''}}" class="text-white link-text-glow">Returns & Exchanges</a></li>
                                    <li><a href="{{isset($store->slug) && !empty($store->slug) ? url('store/'.$store->slug.'/shipping_delivery') : ''}}" class="text-white link-text-glow">Shipping & Delivery</a></li>
                                    <li><a href="{{isset($store->slug) && !empty($store->slug) ? url('store/'.$store->slug.'/privacy_policy') : ''}}" class="text-white link-text-glow">Privacy Policy</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 left">
                <div class="cust-copyright-sec copyright mb--30">
                    <p class="text-white">© 2021 <a class="link-white" href="ecom.premiumblindsuk.com">{{isset($store->slug) && !empty($storeSetting->footer_text) ? $storeSetting->footer_text:''}}</a>
                        All Right Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

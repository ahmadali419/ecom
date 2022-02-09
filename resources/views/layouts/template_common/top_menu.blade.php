<header id="header" class="htc-header header--3 bg__white">
    <!-- Start Mainmenu Area -->

    <div id="sticky-header-with-topbar" class="mainmenu__area sticky__header bg-primary">
        <div class="mobile-view-menu container">
            <div class="row">
                <!-- Start MAinmenu Ares -->
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                    <nav class="mainmenu__nav hidden-xs hidden-sm">
                        <ul class="main__menu">
                            <li class="drop"><a>Blinds</a>
                                <ul class="dropdown">
                                @if(!$storeProductCategory->isEmpty())
                                        @foreach($storeProductCategory as $storeCatObj)
                                            <li><a href="{{route('store.categorie.product',[$storeCatObj->id])}}" class="link-primary">{{ucfirst($storeCatObj->name)}}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                            <li><a href="{{isset($storeSetting->slug) && !empty($storeSetting->slug) ? url('store/'.$storeSetting->slug.'/about_us') : ''}}">About Us</a></li>
                            <li><a>Help</a></li>
                            <li><a>Quick Quote</a></li>
                            <li class="drop"><a>Inspiration</a>
                                <ul class="dropdown mega_dropdown">
                                    <!-- Start Single Mega MEnu -->
                                    <li><a class="mega__title link-primary">Collection</a>
                                        <ul class="mega__item">
                                            @if(!$storeProductCategory->isEmpty())
                                                @foreach($storeProductCategory as $storeCatObj)
                                                    <li><a href="{{route('store.categorie.product',[$storeCatObj->id])}}" class="link-primary">{{ucfirst($storeCatObj->name)}}</a></li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </li>
                                    <!-- End Single Mega MEnu -->
                                    <!-- Start Single Mega MEnu -->
                                    <li><a class="mega__title link-primary" href="#">Best Sellers</a>
                                        <ul class="mega__item">
                                            <li><a href="#" class="link-primary">Gray Blinds</a></li>
                                            <li><a href="#" class="link-primary">Red Blinds</a></li>
                                            <li><a href="#" class="link-primary">Black Blinds</a></li>
                                            <li><a href="#" class="link-primary">White Wooden Venetian Blinds</a></li>
                                            <li><a href="#" class="link-primary">Grey Wooden Venetian Blinds</a></li>
                                            <li><a href="#" class="link-primary">Natural Wooden Venetian Blinds</a></li>
                                            <li><a href="#" class="link-primary">Blackout Roller Blinds</a></li>
                                            <li><a href="#" class="link-primary">Grey Roller Blinds</a></li>
                                            <li><a href="#" class="link-primary">Blackout Vertical Blinds</a></li>
                                            <li><a href="#" class="link-primary">Grey Vertical Blinds</a></li>
                                            <li><a href="#" class="link-primary">Grey Day & Night Blinds</a></li>
                                            <li><a href="#" class="link-primary">Classic Curtains</a></li>
                                            <li><a href="#" class="link-primary">Pattern Curtains</a></li>
                                        </ul>
                                    </li>
                                    <!-- End Single Mega MEnu -->
                                    <!-- Start Single Mega MEnu -->
                                    <li><a class="mega__title link-primary" href="#">Colors</a>
                                        <ul class="mega__item">
                                            @if(isset($storeProductColor))
                                            @if(!$storeProductColor->isEmpty())
                                                @foreach($storeProductColor as $storeColorObj)
                                                    <li><a href="{{route('store.color.product',[$storeColorObj->id])}}" class="link-primary">{{ucfirst($storeColorObj->name)}}</a></li>
                                                @endforeach
                                            @endif
                                            @endif
                                        </ul>
                                    </li>
                                    <!-- End Single Mega MEnu -->
                                    <!-- Start Single Mega MEnu -->
                                    <li><a class="mega__title link-primary" href="#">Rooms Blinds</a>
                                        <ul class="mega__item">
                                            @if(isset($storeProductTag))
                                            @if(!$storeProductTag->isEmpty())
                                                @foreach($storeProductTag as $storeTagObj)
                                                    <li><a href="{{route('store.tag.product',[$storeTagObj->id])}}" class="link-primary">{{ucfirst($storeTagObj->name)}}</a></li>
                                                @endforeach
                                            @endif
                                            @endif
                                        </ul>
                                    </li>
                                    <!-- End Single Mega MEnu -->
                                </ul>
                            </li>
                            <li><a href="contact.html">contact</a></li>
                        </ul>
                    </nav>
                    <div class="mobile-menu clearfix visible-xs visible-sm">
                        <nav id="mobile_dropdown">
                            <ul>
                                <li><a href="shop.html">Blinds</a>
                                    <ul class="dropdown">
                                       @if(!$storeProductCategory->isEmpty())
                                            @foreach($storeProductCategory as $storeCatObj)
                                                    <li><a href="{{route('store.categorie.product',[$storeCatObj->id])}}" class="link-primary">{{ucfirst($storeCatObj->name)}}</a></li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </li>
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Help</a></li>
                                <li><a href="#">Quick Quote</a></li>
                                <li><a href="shop.html">Inspiration</a>
                                    <ul>
                                        <!-- Start Single Mega MEnu -->
                                        <li><a href="#">Collection</a>
                                            <ul>

                                                @if(!$storeProductCategory->isEmpty())
                                                    @foreach($storeProductCategory as $storeCatObj)
                                                            <li><a href="{{route('store.categorie.product',[$storeSetting->slug,$storeCatObj->id])}}" class="link-primary">{{ucfirst($storeCatObj->name)}}</a></li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </li>
                                        <!-- End Single Mega MEnu -->
                                        <!-- Start Single Mega MEnu -->
                                        <li><a href="#">Best Sellers</a>
                                            <ul>
                                                <li><a href="#">Gray Blinds</a></li>
                                                <li><a href="#">Red Blinds</a></li>
                                                <li><a href="#">Black Blinds</a></li>
                                                <li><a href="#">White Wooden Venetian Blinds</a></li>
                                                <li><a href="#">Grey Wooden Venetian Blinds</a></li>
                                                <li><a href="#">Natural Wooden Venetian Blinds</a></li>
                                                <li><a href="#">Blackout Roller Blinds</a></li>
                                                <li><a href="#">Grey Roller Blinds</a></li>
                                                <li><a href="#">Blackout Vertical Blinds</a></li>
                                                <li><a href="#">Grey Vertical Blinds</a></li>
                                                <li><a href="#">Grey Day & Night Blinds</a></li>
                                                <li><a href="#">Classic Curtains</a></li>
                                                <li><a href="#">Pattern Curtains</a></li>
                                            </ul>
                                        </li>
                                        <!-- End Single Mega MEnu -->
                                        <!-- Start Single Mega MEnu -->
                                        <li><a href="#">Colors</a>
                                            <ul>
                                                @if(isset($storeProductColor))
                                                @if(!$storeProductColor->isEmpty())
                                                    @foreach($storeProductColor as $storeColorObj)
                                                            <li><a href="{{route('store.color.product',[$storeColorObj->id])}}" class="link-primary">{{ucfirst($storeColorObj->name)}}</a></li>
                                                    @endforeach
                                                @endif
                                                @endif
                                            </ul>
                                        </li>
                                        <!-- End Single Mega MEnu -->
                                        <!-- Start Single Mega MEnu -->
                                        <li><a href="#">Rooms Blinds</a>
                                            <ul>
                                                @if(isset($storeProductTag))
                                                @if(!$storeProductTag->isEmpty())
                                                    @foreach($storeProductTag as $storeTagObj)
                                                            <li><a href="{{route('getProductByTag',$storeTagObj->id)}}" class="link-primary">{{ucfirst($storeTagObj->name)}}</a></li>
                                                    @endforeach
                                                @endif
                                                @endif
                                            </ul>
                                        </li>
                                        <!-- End Single Mega MEnu -->
                                    </ul>
                                </li>
                                <li><a href="contact.html">contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="cust-mobile-menu mobile-menu-area"></div>
        </div>
    </div>
    <!-- End Mainmenu Area -->
</header>

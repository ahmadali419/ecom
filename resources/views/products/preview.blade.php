@extends('layouts.app')

@section('title', 'Preview Product')
@section('description', 'Preview Product')

@section('page_level_css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
    integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
    integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"
    integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--style Code : Start -->
<style>
.cover img {
    height: 300px;
}

ul {
    list-style: none;
}

i {
    color: yellow;
    padding-right: 7px;
}

h5 {
    font-weight: bold;

}

li {
    display: list-item;
    list-style-type: "⭐";
    padding-inline-start: 1ch;
}

.item img {
    width: 108px;
    height: 60px;
}

.slick-prev {
    color: black;
}

.slick-prev:hover {
    color: black;
}

.slick-prev::before {
    color: black;
}

.slick-next {
    color: black;
}

.slick-next:hover {
    color: black;
}

.slick-next::before {
    color: black;
}

@media (min-width: 375px) {
    .cover img {
        height: 143px;
    }

    .item img {
        width: 49px;
        height: 41px;
    }

}

@media (min-width: 768px) {
    .cover img {
        height: 238px;
    }

    .item img {
        width: 64px;
        height: 48px;
    }


}

@media (min-width: 992px) {
    .cover img {
        height: 334px;
    }

    .item img {
        width: 84px;
        height: 62px;
    }
}

@media (min-width: 1200px) {
    .cover img {
        height: 334px;
    }

    .item img {
        width: 105px;
        height: 76px;
    }

    h5,
    p,
    li {
        font-size: 14px;
    }

}
</style>
<!--style Code : End -->

@endsection



@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Entry Code -->
    <div class="container">
        <!--begin::Card-->
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3>{{!empty($singleProduct->name) ? $singleProduct->name:''}}</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class=" cover">
                            <img src="{{asset('product/coverimage').'/'.$singleProduct->main_image}}"
                                class="w-100 rounded" />
                        </div>
                        <br>
                        <div class=" cover col-lg-12 col-md-12 col-12">
                            <div class="container">
                                <div class=" slider">
                                    @foreach ($singleProduct->product_images as $key => $imgObj)
                                    <div class="item ">
                                        <img class="modal-target" data-toggle="modal" data-target="#exampleModalCenter"
                                            src="{{asset('product/productimages/').'/'.$imgObj->image}}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- Modal-->
                        <div class="modal fade col-12" id="exampleModalCenter" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body"><span id="modal-close" class="modal-close"></span>
                                        <img id="modal-content" class="modal-content">
                                        <div id="modal-caption" class="modal-caption"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                    <br>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-6 row">
                                    <h5><b>Category:&nbsp;</b></h5>
                                    <p>{{!empty($singleProduct->product_category->name) ? $singleProduct->product_category->name:''}}
                                    </p>
                                </div>
                                <div class="col-lg-6  col-md-6 col-6 row">
                                    <h5><b>Color:&nbsp;</b></h5>
                                    <p>{{!empty($singleProduct->product_color->name) ? $singleProduct->product_color->name:''}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <div class="row">
                                <div class="col-lg-6  col-md-6 col-6 row">
                                    <h5><b>Min Length:&nbsp;</b></h5>
                                    <p>{{!empty($singleProduct->min_order_length) ? $singleProduct->min_order_length.' inch ':''}}
                                    </p>
                                </div>
                                <div class="col-lg-6  col-md-6 col-6 row">
                                    <h5><b>Min Width:&nbsp;</b></h5>
                                    <p>{{!empty($singleProduct->min_order_width) ? $singleProduct->min_order_width.' inch ':''}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class=" row">
                                <h5><b>Product Code:&nbsp;</b></h5>
                                <p>{{!empty($singleProduct->sku) ? $singleProduct->sku:''}}</p>
                            </div>
                        </div>
                        <div class="pro__feature">
                            <h5><b>Features</b></h5>
                            <ul class="feature__list">
                                @if(!empty($singleProduct->features))
                                @foreach (unserialize($singleProduct->features) as $key=>$productObj)
                                <li>{{$productObj}}</li>
                                @endforeach
                                @endif

                            </ul>
                        </div>
                    </div>
                    <br>
                    <div class="detail col-lg-6 col-md-6 col-12">
                        <h5><b>Description:</b></h5>
                        <p>{!!json_decode($singleProduct->description)!!}
                        </p>
                    </div>

                    <!-- Modal-->

                </div>


            </div>
        </div>
    </div>
    <!--end::Card-->
</div>
<!--end::Container-->
</div>
</div>
@endsection
@section('page_level_js_plugins')

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
    integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$('.slider').slick({
    dots: false,
    nav: true,
    margin: 10,
    infinite: true,
    autoplay: true,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [{
            breakpoint: 1024,
            settings: {
                slidesToShow: 6,
                slidesToScroll: 1,
                infinite: true,
                dots: false
            }
        },
        {
            breakpoint: 800,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                dots: false
            }
        }, {
            breakpoint: 0,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                dots: true
            }
        }, {
            breakpoint: 600,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1
            }
        }, {
            breakpoint: 480,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 1
            }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
    ]
});

var modal = document.getElementById('exampleModalCenter');

var modalClose = document.getElementById('modal-close');
modalClose.addEventListener('click', function() {
    modal.style.display = "none";
});

// global handler
document.addEventListener('click', function(e) {
    if (e.target.className.indexOf('modal-target') !== -1) {
        var img = e.target;
        var modalImg = document.getElementById("modal-content");
        var captionText = document.getElementById("modal-caption");
        modal.style.display = "block";
        modalImg.src = img.src;
        captionText.innerHTML = img.alt;
    }
});
</script>

@endsection
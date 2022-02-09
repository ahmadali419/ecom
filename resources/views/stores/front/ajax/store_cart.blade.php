
<div class="shopping__cart__inner">
    <div class="offsetmenu__close__btn close_cart">
        <a ><i class="zmdi zmdi-close link-primary"></i></a>
    </div>
    <div class="shp__cart__wrap">
        @php
            $cart= session()->get($slug);

            $subtotal = 0;

        @endphp
        @if(!empty($cart))
            @foreach($cart as $productId => $arr)
                @php
                    $k = array_key_first($arr);
                @endphp
                @if(!empty($k))
                <div class="shp__single__product">
                    <div class="shp__pro__details">
                        <div class="shp__pro__thumb">
                            <a>
                                <img src="{{$arr[$k]['image']}}" alt="product images">
                            </a>
                        </div>
                        <table class="table table-borderless">
                            @foreach($arr as $dim => $ca)
                                @php
                                    $subtotal += $ca['price'];
                                @endphp
                                <tr>
                                    <td>
                                        <h2>{{ucfirst($ca['product_name'])}}</h2>
                                    </td>
                                    <td>
                                        {{ $dim }}
                                    </td>
                                    <td>
                                        <span class="quantity">{{$ca['quantity']}}</span>
                                    </td>
                                    <td>
                                        <span class="shp__price text-primary">£ {{$ca['price']}}</span>
                                    </td>
                                    <td>
                                        <div class="remove__btn">
                                            <a  onclick="removeproduct({{$productId}},'{{$dim}}')" title="Remove this item"><i class="zmdi zmdi-close link-primary"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                @endif
            @endforeach
        @endif
    </div>
    @if($subtotal > 0)
    <ul class="shoping__total padding-0 mb--10">
        <li class="subtotal">Subtotal:</li>
        <li class="total__price text-primary">£ {{$subtotal}}</li>
    </ul>
    <ul class="shoping__total padding-0 mb--20">
        <li class="subtotal">Total:</li>
        <li class="total__price text-primary">£ {{$subtotal}}</li>
    </ul>
    <ul class="width-100 d-flex justify-content-between">
        <li class=""><a class="btn-primary text-center width-100" href="{{route('user.viewCart',[$slug])}}" >View Cart</a></li>
        <li class=""><a class="btn-secondary-outer text-center width-100" href="{{route('cart.checkout',[$slug])}}">Checkout</a></li>
    </ul>
    @endif
</div>

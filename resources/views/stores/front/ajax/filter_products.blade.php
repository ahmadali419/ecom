 @if(!($productsData->isEmpty()))
    @foreach ($productsData as $productObj)
        <div class="col-md-3  col-lg-3 col-sm-4 col-xs-12 cat--3">
             <div class="product foo">
                 <div class="product__inner">
                     <div class="pro__thumb">
                         <a
                             href="{{ route('store.product.detail', [$productObj->id]) }}">
                             <img src="{{ asset('product/coverimage') . '/' . $productObj->main_image }}"
                                 alt="product images">
                         </a>
                     </div>
                     <div class="product__hover__info">
                         <ul class="product__action border-normal bg-primary">
                             <li><a onclick="showSingleProduct({{$productObj->id}},'modal')"
                                    title="Quick View"
                                     class="quick-view modal-view detail-link"
                                     ><span class="ti-plus"></span></a>
                             </li>
                             <li><a title="Add TO Cart" href="{{route('user.viewCart',[$store->slug])}}"><span
                                         class="ti-shopping-cart"></span></a></li>
                             <li>
                                 <input type='checkbox' id="productck_{{$productObj->id}}"  @if(!empty($productObj->wishID)) checked @endif onclick="addWhishList({{$productObj->id}},{{isset($productObj->wishID) && $productObj->wishID > 0 ? $productObj->wishID :'-1'}})"/><label for="productck_{{$productObj->id}}"></label>
                             </li>
                         </ul>
                     </div>
                 </div>
                 <div class="product__details">
                     <h2><a class="link-secondary"
                             href="{{ route('store.product.detail', [$productObj->id]) }}">{{ $productObj->name }}</a>
                     </h2>
                     <ul class="product__price">
                         {{-- <li class="old__price">£16.00</li> --}}
                         <li class="new__price text-primary">£{{$productObj->sale_price }}</li>
                     </ul>
                 </div>
             </div>
         </div>
    @endforeach
@endif

    @if(!$userOrder->isEmpty())

    @foreach($userOrder as $Order)
        <details>
            <summary role="button" tabindex="0" class="row margin-0">
                <span class="col-md-3 col-sm-6 col-xs-6 mt--10">{{$Order->id}}</span>
                <span class="col-md-3 col-sm-6 col-xs-6 text-right mt--10">{{date('d/m/Y',strtotime($Order->created_at))}}</span>
                <span class="col-md-3 col-sm-6 col-xs-6 text-center padding-1 bg-primary img-rounded border-0">
                                                               {{ucfirst($Order->status)}}
                                                            </span>
                <span class="col-md-3 col-sm-6 col-xs-6 ti-arrow-down text-right mt--10"></span>
            </summary>

            <div class="padding-4">


                <div>
                    @foreach($Order->orderdetail as $orderItem)
                        <div class="shp__single__product">
                            <div class="row width-100">
                                <div class="col-lg-9 col-md-9 col-sm-12">
                                    <div class="shp__pro__thumb mb--10">
                                        <a href="#">
                                            <img
                                                src="{{ asset('product/coverimage') . '/' . $orderItem->orderProducts->main_image }}"
                                                alt="product images">
                                        </a>
                                    </div>
                                    <div class="shp__pro__details">
                                        <h2>{{ucfirst($orderItem->orderProducts->name)}}</h2>
                                        <span class="shp__price text-primary">£ {{$orderItem->price}}</span>
                                        <div class="shp__pro__details">
                                            <h2>Dimensions</h2>
                                            <span class="">{{$orderItem->dimension}}</span>
                                            <h6 class="fittings-txt">Qty: <span>{{floor($orderItem->qty)}}</span></h6>
                                            <h6 class="text-primary">Measurement: <span>{{ucfirst($orderItem->scale)}}</span></h6>
                                            @if(!empty($orderItem->fitting_type))
                                                <h6 class="fittings-txt">Fittings: <span>{{ucfirst($orderItem->fitting_type)}}</span></h6>
                                            @endif
                                            @if(!empty($orderItem->chain_color))
                                                <h6 class="fittings-txt">Chain Color: <span>{{ucfirst($orderItem->chain_color)}}</span></h6>
                                            @endif
                                            @if(!empty($orderItem->side_control))
                                                <h6 class="fittings-txt">Side Controls: <span>{{ucfirst($orderItem->side_control)}}</span></h6>
                                            @endif
                                            @if(!empty($orderItem->fitting_option))
                                                <h6 class="fittings-txt">Fitting Option: <span>{{ucfirst($orderItem->fitting_option)}}</span></h6>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>


                <ul class="shoping__total padding-0 mb--10">
                    <li class="subtotal">Total:</li>
                    <li class="total__price text-primary">£{{$Order->total_price}}</li>
                </ul>



            </div>


        </details>
    @endforeach
    @else
        <h5>Sorry No Record Found!</h5>
    @endif


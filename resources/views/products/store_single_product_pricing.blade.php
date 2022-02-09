<div class="row">
    <div class="col-sm-12">
        <h4>Buying Price</h4>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                @php
                    $outerLoop = 0;
                @endphp
                @if(!empty($originalBandPrice))
                    @foreach($originalBandPrice as $length => $widthArr)
                        <tr>
                            <th>{{ $length }}</th>
                            @foreach($widthArr as $width => $price)
                                @if($outerLoop == 0)
                                    <th>{{ $width }}</th>
                                @else
                                    <td>{{ number_format($price, 1) }}</td>
                                @endif
                            @endforeach
                        </tr>
                        @php
                            $outerLoop++;
                        @endphp
                    @endforeach
                @endif
            </table>
        </div>
    </div>
    <div class="col-sm-12">
        <form method="post" id="single_product_pricing_form">
            <input type="hidden" name="sppm_id" value="{{ $storeProductPricingMappingId }}">
            <input type="hidden" name="store_id" value="{{ $storeId }}">
            <input type="hidden" name="contract_id" value="{{ $contractId }}">
            <input type="hidden" name="product_id" value="{{ $productId }}">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>Margin</label>
                    <input type="text" name="margin" id="margin" value="{{ $margin }}" class="form-control" placeholder="Enter Margin">
                </div>
                <div class="form-group col-md-4">
                    <label>Vat</label>
                    <input type="text" name="vat" id="vat" value="{{ $vat }}" class="form-control" placeholder="Enter Vat">
                </div>
                <div class="form-group col-md-4">
                    <label>Discount</label>
                    <input type="text" name="discount" id="discount" value="{{ $discount }}" class="form-control" placeholder="Enter Discount">
                </div>
                <div class="form-group col-md-12 text-right">
                    <button type="button" id="btn_save_single_product_pricing" class="btn btn-primary mr-2">Apply Pricing</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-12">
        <h4>Selling Price</h4>
        <div class="table-responsive table-hover table-bordered">
            <table class="table">
                @php
                    $outerLoop = 0;
                @endphp
                @if(!empty($calculateProductPrice))
                    @foreach($calculateProductPrice as $length => $widthArr)
                        <tr>
                            <th>{{ $length }}</th>
                            @foreach($widthArr as $width => $price)
                                @if($outerLoop == 0)
                                    <th>{{$width}}</th>
                                @else
                                    <td>{{ number_format($price, 1) }}</td>
                                @endif
                            @endforeach
                        </tr>
                        @php
                            $outerLoop++;
                        @endphp
                    @endforeach
                @endif
            </table>
        </div>
    </div>
</div>

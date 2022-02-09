<?php

namespace App\Http\Controllers;
use App\Models\Band;
use App\Models\BandPriceMapping;
use App\Models\Product;
use App\Models\ProductContractMapping;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use App\Models\StoreProductPricingMapping;
use App\Models\Charge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class StoreProductPricingMappingController extends Controller
{
    public function getStoreProductPrice(Request $request) {
        $product_id = $request->id;
        $storeId = $request->store_id;
        $store = Store::find($storeId);
        $product = Product::find($product_id);
        $bandPriceMapping = BandPriceMapping::where('band_id',$product->band_id)->get();
        $productContractMapping = ProductContractMapping::where('product_id',$product_id)->where('contract_id', $store->contract_id)->first();
        $storeProductPricingMapping = StoreProductPricingMapping::where('store_id', $storeId)->where('product_id', $product_id)->first();

        $storeContractDiscount = 0;
        if(!empty($productContractMapping->discount)) {
            $storeContractDiscount = $productContractMapping->discount;
        }
        $originalBandPrice = [];
        if(!empty($bandPriceMapping)) {
            foreach($bandPriceMapping as $bandPriceMappingObj) {
                $price = $bandPriceMappingObj->price;
                if($storeContractDiscount > 0) {
                    $discountPrice = (($storeContractDiscount/100) *  $price);
                    $price = ($price - $discountPrice);
                }

                $originalBandPrice['L/w'][$bandPriceMappingObj->width] = $price;
                $originalBandPrice[$bandPriceMappingObj->length][$bandPriceMappingObj->width] = $price;
            }
        }
        $margin = 0;
        if(!empty($storeProductPricingMapping->margin)) {
            $margin = $storeProductPricingMapping->margin;
        }
        $vat = 0;
        if(!empty($storeProductPricingMapping->vat)) {
            $vat = $storeProductPricingMapping->vat;
        }
        $discount = 0;
        if(!empty($storeProductPricingMapping->discount)) {
            $discount = $storeProductPricingMapping->discount;
        }
        $calculateProductPrice = [];
        if(count($originalBandPrice)) {
            foreach($originalBandPrice as $length => $widthArr) {
                foreach($widthArr as $width => $price) {
                    $marginValue = 0;
                    if($margin > 0) {
                        $marginValue = (($margin / 100) * $price);
                    }
                    $vatValue = 0;
                    if($vat > 0) {
                        $vatValue = (($vat / 100) * $price);
                    }
                    $price = ($price + ($marginValue + $vatValue));
                    $discountValue = 0;
                    if($discount > 0) {
                        $discountValue = (($discount / 100) * $price);
                    }
                    $price = number_format((float)($price - $discountValue), 2);
                    $calculateProductPrice[$length][$width] = $price;
                }
            }
        }
        $dt = [

            'storeProductPricingMappingId' => $storeProductPricingMapping->id,
            'productId' => $product_id,
            'storeId' => $storeId,
            'contractId' => $store->contract_id,
            'margin' => $margin,
            'vat' => $vat,
            'discount' => $discount,
            'originalBandPrice' => $originalBandPrice,
            'calculateProductPrice' => $calculateProductPrice

        ];

        $html = view('products/store_single_product_pricing', $dt)->render();
        $response = [
            'html' => $html
        ];
        return response()->json($response);
    }

    public function updateStoreSingleProductPrice(Request $request) {
        $sppmId = $request->sppm_id;
        $storeId = $request->store_id;
        $contractId = $request->contract_id;
        $productId = $request->product_id;
        $margin = $request->margin;
        $vat = $request->vat;
        $discount = $request->discount;

        $originalProductPrice = 0.00;
        $contractDiscount = 0.00;
        $product = Product::find($productId);
        $bandPriceMapping = BandPriceMapping::where('band_id',$product->band_id);
        $bandPriceMapping->where(function($q){
            $q->min('length');
            $q->min('width');
        });
        $originalProductPrice = $bandPriceMapping->pluck('price')->first();
        $contractDiscount = ProductContractMapping::where('product_id',$productId)->where('contract_id', $contractId)->pluck('discount')->first();
        $buyingPrice = ($originalProductPrice - (($contractDiscount / 100) * $originalProductPrice));
        $valueAdd = (((($margin + $vat) - $discount) / 100) * $buyingPrice);
        $sellingPrice = number_format(($buyingPrice + $valueAdd), 2);
        $update = [
            'margin' => $margin,
            'vat' => $vat,
            'discount' => $discount,
            'sale_price' => $sellingPrice
        ];
        StoreProductPricingMapping::where('id', $sppmId)->update($update);
        $return = [
            'status' => 'success',
            'store_id' => $storeId,
            'product_id' => $productId,
            'message' => 'Single product price save successfully',
        ];
        return response()->json($return);

    }

    public function storeProductPricing(Request $request)
    {
       // echo "yess";exit;
        $validate = true;
        $validateInput = $request->all();
        $rules = [
          'charge_id.*' => 'required',
          'charge_value.*' => 'required',
          'product_id' => 'required',
          'store_id' => 'required',


        ];

        $validator = Validator::make($validateInput,$rules);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $allMsg = [];
            foreach ($errors->all() as $message) {
                $allMsg[] = $message;
            }
            $return['status'] = 'error';
            $return['message'] = collect($allMsg)->implode('<br />');
            $validate = false;
            return response()->json($return);
        }
        if ($validate) {

            $chargestype=$request->charge_id;
            $charge_value=$request->charge_value;
            $pricedata=array();
            foreach($chargestype as $key=>$type)
            {

                $pricedata[]=array(
                    'product_id'=>$request->product_id,
                    'store_id'=>$request->store_id,
                    'charges_id'=>$type,
                    'charges_value'=>$charge_value[$key],

                );

            }

            StoreProductPricingMapping::where('product_id',$request->product_id)->where('store_id',$request->store_id)->where('deleted_at','=',NULL)->delete();
            $query=StoreProductPricingMapping::insert($pricedata);
            $return = [
                'status' => 'error',
                'message' => 'Store product price mapping not  saved successfully',
            ];
            if ($query) {
                $return = [
                    'status' => 'success',
                    'message' => 'Store product price mapping save successfully',
                ];
            }
            return response()->json($return);
        }




    }

//
//    public function getStoreProducts(Request $request)
//    {
//        $id = $request->id;
//        // echo $id;exit;
//        if (!empty($id)) {
//            $store = Store::where('id', $id)->first();
//            $productIds = DB::table('store_product_mappings')->where('store_id', $id)->pluck('product_id')->toArray();
//            // print_r($productIds);exit;
//            if (count($productIds)) {
//                $productIds = array_map('strval', $productIds);
//            }
//            $return = [
//                'status' => 'success',
//                'data' => $store,
//                'product_ids' => $productIds
//            ];
//            if (empty($store)) {
//                $return = [
//                    'status' => 'error',
//                    'message' => 'Data not found for edit'
//                ];
//            }
//            return response()->json($return);
//        }
//    }
//
//    public function assignProducts(Request $request)
//    {
//
//        DB::table('store_product_mappings')->where('store_id',$request->store_id)->delete();
//        $productIds = $request->product_id;
//        // echo $productIds;exit;
//        if (!empty($productIds)) {
//            foreach ($productIds as $productId) {
//                $storeHasProductData = [
//                    'product_id' => $productId,
//                    'store_id' => $request->store_id
//                ];
//                $query =  StoreProductMapping::insert($storeHasProductData);
//            }
//        }
//
//        $return = [
//            'status' => 'success',
//            'message' => 'Data is save successfully',
//        ];
//
//        return response()->json($return);
//    }





}

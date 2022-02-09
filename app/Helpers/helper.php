<?php

use App\Models\BandPriceMapping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Store;
use App\Models\Product;
use App\Models\ProductCentimeter;
use App\Models\ProductMilimeter;
use App\Models\ProductInch;
use App\Models\Category;
use App\Models\ProductContractMapping;
use App\Models\UserStoreMapping;
use App\Models\Contract;
use App\Models\StoreProductMapping;
use App\Models\StoreSetting;
use App\Models\ProductTag;
use App\Models\StoreProductPricingMapping;

function hasPermission($name)
{
    $permissionObj = Permission::where('name', $name)->first();
    if (!empty($permissionObj)) {
        $userRoleId = Auth::user()->role_id;
        $roleHasPermission = DB::table('role_has_permissions')->where('role_id', $userRoleId)->where('permission_id', $permissionObj->id)->first();
        if (empty($roleHasPermission)) {
            return false;
        }
    } else {
        return false;
    }
    return true;
}

function getCategoryTypes()
{
    $userType = auth()->user()->type;
    $types = [];
    if ($userType == 'super_admin') {
        $types['permission'] = 'Permission';
    }
    $types['product'] = 'Product';
    return $types;
}

function getCategory($categoryObjs = false, $categoryId = "", $type = "product",$storeID='')
{

    $role=array('super_admin','customer');
    $storeIds = getUserStore();
    // print_r($storeIds);exit;
    $query = Category::whereNull('deleted_at');
    if (!empty($storeIds) && ((auth()->check()) && (!in_array(auth()->user()->type,$role)))) {
        $contractIds = Store::whereIn('id', $storeIds)->pluck('contract_id')->toArray();
        $productIds = ProductContractMapping::whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        $categoyIds = Product::whereIn('id', $productIds)->pluck('category_id')->toArray();
        $query->withCount(['products'=> function ($query) use ($productIds) {
            $query->whereIn('id', $productIds);
            // $query->join('store_product_price_mappings')
        }]);
        $query->whereIn('id', $categoyIds);
    }
    elseif($storeID){

        //echo "i am here";exit;
        $contractIds = Store::where('id', $storeID)->pluck('contract_id')->toArray();
        //$productIds = ProductContractMapping::whereNULL('deleted_at')->whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        $productIds = StoreProductPricingMapping::whereNULL('deleted_at')->where('store_id', $storeID)->pluck('product_id')->toArray();
        $categoyIds = Product::whereNULL('deleted_at')->whereIn('id', $productIds)->pluck('category_id')->toArray();
        $query->withCount(['products'=> function ($query) use ($productIds) {
            $query->whereIn('id', $productIds);
        }]);
        $query->whereIn('id', $categoyIds);

    }
    else{

        $query->withCount('products');
    }

    $result = [];
    if ($categoryObjs) {
        $result = $query->get();
    }
    else {
        $result = $query->pluck('id')->toArray();
    }
    if ($categoryId > 0) {

        $query->where('id', $categoryId);
        $result = $query->first();
    }
    if ($type != "") {
        $query->where('type', $type);
        if ($categoryObjs) {
            $result = $query->get();
        } else {

            $result = $query->pluck('id')->toArray();
        }
    }

    return $result;
}

function getUserStore($storeObjs = false, $storeId = "")
{
    $usertype = '';
    $userId = '';
    if (Auth::check()) {
        $userId = auth()->user()->id;
        $usertype = auth()->user()->type;
    } else {
        $domain = getDomainSlug();
        $storeId = StoreSetting::where('slug', $domain->slug)->pluck('store_id')->first();
    }
    $query = Store::select('stores.*')->whereNULL('deleted_at');
    if (Auth::check() && $usertype != 'super_admin') {
        $query->join('user_store_mappings', 'user_store_mappings.store_id', '=', 'stores.id');
        $query->where('user_store_mappings.user_id', $userId);
    }

    $result = [];
    if ($storeObjs) {
        $result = $query->get();
    } else {
        $result = $query->pluck('id')->toArray();
    }
    if ($storeId) {

        $query->where('stores.id', $storeId);
        if ($storeObjs) {
            $result = $query->first();
        } else {
            $result = $query->pluck('id')->toArray();
        }
    }
    return $result;
}

function getUserContract($contractObjs = false) {
    $usertype = 'shop';
    if (Auth::check()) {
        $usertype = auth()->user()->type;
    }
    $storeIds = getUserStore();
    $query = Contract::select('contracts.*');
    $query->join('stores', 'stores.contract_id', '=', 'contracts.id');
    $query->whereIn('stores.id', $storeIds);
    $result = [];
    if ($contractObjs) {
        $result = $query->get();
    } else {
        $result = $query->pluck('id')->toArray();
    }
    return $result;
}

function getProducts($productObj = false, $productIds = [])
{
    $contractIds = getUserContract();
    // print_r($contractIds);exit;
    $query = Product::select('products.*','band_price_mappings.length as min_product_length','band_price_mappings.length as min_product_width','band_price_mappings.price as min_product_price','store_product_pricing_mappings.margin','store_product_pricing_mappings.vat','store_product_pricing_mappings.discount','store_product_pricing_mappings.sale_price', 'product_contract_mappings.discount as contract_discount');
    $query->join('band_price_mappings', function($join){
        $join->on('band_price_mappings.band_id', 'products.band_id');
        $join->on('band_price_mappings.length', 'products.min_order_length');
        $join->on('band_price_mappings.width', 'products.min_order_width');
    });
    $query->join('product_contract_mappings', 'product_contract_mappings.product_id', '=', 'products.id');
    $query->leftjoin('store_product_pricing_mappings', 'store_product_pricing_mappings.product_id', '=', 'products.id');

    $query->whereIn('product_contract_mappings.contract_id', $contractIds);
    if(!empty($productIds)) {
        if(is_array($productIds)) {
            $query->whereIn('products.id', $productIds);
        } else {
            $query->where('products.id', $productIds);
        }
    }
    $query->whereNull('store_product_pricing_mappings.deleted_at');
    $query->whereNull('product_contract_mappings.deleted_at');
    $query->groupBy('products.id');
    if ($productObj) {
        if(!empty($productIds) && !is_array($productIds)) {
            $result = $query->first();
        } else {
            $result = $query->get();
        }
    } else {
        $result = $query->pluck('id')->toArray();
    }
//    echo "<pre>"; print_r($result);exit;
    return $result;
}


function getProductByID($productID=-1,$contractID=-1,$categoryID=-1,$storeID=-1)
{
    $singleProduct = Product::with(['product_images'=>function($query) use($productID){
        $query->where('deleted_at',NULL);
    }]);
    $singleProduct->whereNull('products.deleted_at')->selectRaw("products.*,store_product_pricing_mappings.sale_price,product_contract_mappings.discount");
    $singleProduct->join('store_product_pricing_mappings','store_product_pricing_mappings.product_id','products.id');
    $singleProduct->join('product_contract_mappings', 'product_contract_mappings.product_id', '=', 'store_product_pricing_mappings.product_id');
    if(Auth::check() && auth()->user()->type=='customer'){
        $singleProduct->selectRaw("wish_lists.id as wishID,wish_lists.product_id as ProductWishID");
        $singleProduct->leftJoin('wish_lists', function($join) {
            $join->on('wish_lists.product_id', '=', 'products.id');

            $join->where('wish_lists.user_id',auth()->user()->id);
        });
    }
    $singleProduct->where('store_product_pricing_mappings.product_id',$productID);
    $singleProduct->whereNull('store_product_pricing_mappings.deleted_at');
    $singleProduct->whereNull('product_contract_mappings.deleted_at');
    $singleProduct->where('product_contract_mappings.contract_id',$contractID);
    if($storeID > 0){
        $singleProduct->where('store_product_pricing_mappings.store_id',$storeID);
    }
    $result=$singleProduct->first();

    return $result;



}
function getRelatedProduct($productID=-1,$contractID=-1,$categoryID=-1,$storeID=-1)
{
    $products = Product::selectRaw("products.*,store_product_pricing_mappings.sale_price");
    $products->join('store_product_pricing_mappings','store_product_pricing_mappings.product_id','products.id');
    if(Auth::check() && auth()->user()->type=='customer'){
        $products->selectRaw("wish_lists.id as wishID,wish_lists.product_id as ProductWishID");
        $products->leftJoin('wish_lists', function($join) {
            $join->on('wish_lists.product_id', '=', 'products.id');
            $join->where('wish_lists.user_id',auth()->user()->id);
        });
    }
    $result=$products->where('products.deleted_at', '=', NULL)->where('store_product_pricing_mappings.deleted_at', '=', NULL)->where('products.category_id',$categoryID)->where('store_product_pricing_mappings.product_id','!=',$productID)->where('store_product_pricing_mappings.store_id',$storeID)->get();
    return $result;

}
function getContractProducts($contractID)
{
    return $productIDs = ProductContractMapping::where('contract_id',$contractID)->where('deleted_at', '=', NULL)->pluck('product_id')->toArray();
}
function getProductByCategory($categoryId = -1, $colorId = -1, $tagId = -1,$storeID=-1,$colorIds=-1,$minimumRange=-1,$maximumRange=-1)
{

    $role=array('super_admin','customer');
     $paginate =12;
    $storeIds = getUserStore();

    if($storeID > 0){
        // echo "yes";exit;
        $contractIds = Store::where('id', $storeID)->pluck('contract_id')->toArray();
    }
    else{
        $contractIds = Store::whereIn('id', $storeIds)->pluck('contract_id')->toArray();
    }
    if (!empty($storeIds) && ((auth()->check()) && (!in_array(auth()->user()->type,$role)))) {
        $productIds = ProductContractMapping::whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        // print_r($productIds);exit;

        $query = Product::whereNull('deleted_at')->whereIn('products.id', $productIds);
    } elseif (((auth()->check()) && (!in_array(auth()->user()->type,$role)))) {
        $query = Product::whereNull('deleted_at');
    }
    elseif ($storeID > 0) {
        // echo "yes";exit;
        $productIds = ProductContractMapping::whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        $query = Product::whereNull('products.deleted_at')->whereIn('products.id', $productIds)->selectRaw("products.*,store_product_pricing_mappings.sale_price");
        $query->join('store_product_pricing_mappings','store_product_pricing_mappings.product_id','products.id');
        if(Auth::check() && auth()->user()->type=='customer'){
            $query->selectRaw("wish_lists.id as wishID,wish_lists.product_id as ProductWishID");
            $query->leftJoin('wish_lists', function($join) {
                $join->on('wish_lists.product_id', '=', 'products.id');
                $join->where('wish_lists.user_id',auth()->user()->id);
            });
        }
        $query->whereNull('store_product_pricing_mappings.deleted_at');
        $query->where('store_product_pricing_mappings.store_id',$storeID);
        $query->groupBy('products.id');
    }
    else {
        // $storeId = StoreSetting::where('custom_domain', $url)->pluck('store_id')->first();
        $productIds = ProductContractMapping::whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        $query = Product::whereNull('deleted_at')->whereIn('products.id', $productIds);
    }
    if(($minimumRange > 0 && $minimumRange > 0)){
        $query->where('store_product_pricing_mappings.sale_price','>=', $minimumRange);
        // $query->where('store_product_pricing_mappings.sale_price','=', $minimumRange);
    }
    if ($categoryId > 0 && $categoryId != 'undefined') {
        $query->where('category_id', $categoryId);
    }
    if ($colorId > 0) {

        $query->where('color_id', $colorId);
    }
    if (!empty($colorIds[0])) {
        $query->whereIn('color_id', $colorIds);
    }
    if ($tagId > 0) {
        $query->join('product_tags', 'product_tags.product_id', '=', 'products.id');
        $query->where('tag_id', $tagId);
    }
    $query->paginate($paginate);
    $return = $query->get();
    // $queries = DB::getQueryLog();
//    echo "<pre>"; print_r($return);exit;

    return $return;
}
function getContracts()
{
    return $query = DB::table('contracts')->whereNull('deleted_at')->get();
}

function getRole($roleObjs = false)
{
    $userType = Auth::user()->type;
    $roles = [];
    if ($userType == 'super_admin' || $userType == 'employee') {
        if ($roleObjs) {
            $roles = Role::skip(1)->whereNull('store_id')->take(PHP_INT_MAX)->get();
        } else {
            $roles = Role::skip(1)->whereNull('store_id')->take(PHP_INT_MAX)->pluck('id')->toArray();
        }
    } else {
        $storeIds = getUserStore();
        $role = Role::whereIn('store_id', $storeIds);
        if ($roleObjs) {
            $roles = $role->get();
        } else {
            $roles = $role->pluck('id')->toArray();
        }
    }
    return $roles;
}

function getColore($colortObj = false, $colorId = '',$storeID='')
{
    $storeIds = getUserStore();
    $role=array('super_admin','customer');
    $query = DB::table('colors')->whereNull('deleted_at');
    if (!empty($storeIds) && ((auth()->check()) && (!in_array(auth()->user()->type,$role)))) {
        // echo "yes";exit;
        $contractIds = Store::whereIn('id', $storeIds)->pluck('contract_id')->toArray();
        $productIds = ProductContractMapping::whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        $colorIds = Product::whereIn('id', $productIds)->pluck('color_id')->toArray();
        $query->whereIn('id', $colorIds);
    }
    elseif($storeID)
    {
        $contractIds = Store::where('id', $storeID)->pluck('contract_id')->toArray();
        $productIds = ProductContractMapping::whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        $colorIds = Product::whereIn('id', $productIds)->pluck('color_id')->toArray();
        $query->whereIn('id', $colorIds);
    }
    $result = [];
    if ($colortObj) {
        $result = $query->get();
        // print_r($result);exit;

    } else {
        $result = $query->pluck('id')->toArray();
    }
    if ($colorId != "") {
        $query->where('id', $colorId);
        $result = $query->first();
    }

    return $result;
}
function getcharges()
{
    return $query = DB::table('charges')->get();
}

function gettags($tagObj = false, $tagId = '',$storeID='')
{
    $storeIds = getUserStore();
    $role=array('super_admin','customer');
    $query = DB::table('tags')->whereNull('deleted_at');
    if (!empty($storeIds) && ((auth()->check()) && (!in_array(auth()->user()->type,$role)))) {
        $contractIds = Store::whereIn('id', $storeIds)->pluck('contract_id')->toArray();
        $productIds = ProductContractMapping::whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        $tagIdss = ProductTag::whereIn('id', $productIds)->pluck('tag_id')->toArray();
        $query->whereIn('id', $tagIdss);
    }
    elseif($storeID)
    {
        $contractIds = Store::where('id', $storeID)->pluck('contract_id')->toArray();
        $productIds = ProductContractMapping::whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
        $tagIdss = ProductTag::whereIn('product_id', $productIds)->pluck('tag_id')->toArray();
        $query->whereIn('id', $tagIdss);
    }
    $result = [];
    if ($tagObj) {
        $result = $query->get();
    } else {
        $result = $query->pluck('id')->toArray();
    }
    if ($tagId != "") {
        $query->where('id', $tagId);
        $result = $query->first();
    }

    return $result;
}

function saveProductAttribute($productId, $length, $width, $price, $table = 'inches')
{
    $insertData = [];
    foreach ($length as $k => $len) {
        $insertData[] = [
            'product_id' => $productId,
            'length' => $len,
            'width' => $width[$k],
            'price' => $price[$k],
            'created_at' => Carbon::now()->format("Y-m-d H:i:s"),
            'updated_at' => Carbon::now()->format("Y-m-d H:i:s")
        ];
    }
    if (!empty($insertData)) {
        if ($table == 'inches') {
            ProductInch::insert($insertData);
        } else if ($table == 'centimeters') {
            ProductCentimeter::insert($insertData);
        } else if ($table == 'milimeters') {
            ProductMilimeter::insert($insertData);
        }
    }
}



function saveProductTags($productID, $tags)
{
    $tagdata = array();
    DB::table('product_tags')->where('product_id', $productID)->delete();
    foreach ($tags as $key => $value) {
        if (!empty($value)) {
            $tagdata[] = array(

                'product_id' => $productID,
                'tag_id' => $value,
                'created_at' => Carbon::now()->format("Y-m-d H:i:s")

            );
        }
    }

    DB::table('product_tags')->insert($tagdata);
    return 1;
}

function getbands($bandObj = false, $bandId = '')
{
    $query = DB::table('bands')->whereNull('deleted_at');
    if (!empty($storeIds) && ((auth()->check()) && (auth()->user()->type != 'super_admin'))) {
        $productIds = StoreProductMapping::whereIn('store_id', $storeIds)->pluck('product_id')->toArray();
        $bandIdss = Product::whereIn('id', $productIds)->pluck('band_id')->toArray();
        $query->whereIn('id', $bandIdss);
    }
    $result = [];
    if ($bandObj) {
        $result = $query->get();
    } else {
        $result = $query->pluck('id')->toArray();
    }
    if ($bandId != "") {
        $query->where('id', $bandId);
        $result = $query->first();
    }

    return $result;
}

function getProductAdditionalCharges($productID,$storeID=-1)
{

    $charges=StoreProductPricingMapping::where('product_id',$productID)->where('store_id',$storeID)->where('deleted_at',NULL)->first();
    $totalcharges=0;
    /*foreach($charges as $charge)
    {
        if($charge->is_subtract==0)
        {
            $totalcharges+=$charge->charges_value;
        }
        else{
            $totalcharges-=$charge->charges_value;
        }

    }*/
    $margin=isset($charges->margin) && $charges->margin > 0 ? $charges->margin : 0;
    $vat=isset($charges->vat) && $charges->vat > 0 ? $charges->vat : 0;
    $totalcharges+= ($margin + $vat) - $charges->discount;

    return $totalcharges;


}

function calculateProductQuote($productID,$width,$height)
{
    $products = Product::selectRaw("band_price_mappings.length,band_price_mappings.width,band_price_mappings.price");
    $products->join('band_price_mappings','band_price_mappings.band_id','products.band_id');
    $products->where('products.id',$productID)->where('products.deleted_at', '=', NULL);
    $result=$products->where('band_price_mappings.width','>=',$width);
    $result=$products->where('band_price_mappings.length','>=',$height)->first();
    return $result;
}
function overallProductPrice($bandPrice,$additionalCharges=-1,$contractDiscount=-1)
{
    if($contractDiscount > 0){
        $buyingprice=($bandPrice * ($contractDiscount/100));
        $buyingprice=$bandPrice - $buyingprice;
    }
    else{
        $buyingprice=$bandPrice;
    }
    if($additionalCharges > 0){
        // echo $additionalCharges;exit;
        $totalPrice=($buyingprice + ($buyingprice * ($additionalCharges/100)));

    }
    else{
        $totalPrice=$buyingprice;
    }
        return number_format($totalPrice,2);
}

function getFilterPrices($catId = -1,$storeId = -1,$colorIds=-1){
    $contractIds = Store::where('id', $storeId)->pluck('contract_id')->toArray();
    $productIds = ProductContractMapping::whereIn('contract_id', $contractIds)->pluck('product_id')->toArray();
    $bandIds = Product::whereIn('id', $productIds)->pluck('band_id')->toArray();
    $query = Product::whereNull('products.deleted_at')->whereIn('products.id', $productIds)->selectRaw("products.*,store_product_pricing_mappings.*,MIN(store_product_pricing_mappings.sale_price) AS Minprice,MAX(store_product_pricing_mappings.sale_price) AS MaxPrice");
    $query->join('store_product_pricing_mappings','store_product_pricing_mappings.product_id','products.id');
    $query->where('store_product_pricing_mappings.store_id',$storeId);
    $query->groupBy('products.id');
    // if ($catId > 0 && $catId != 'undefined') {
    //     $query->where('products.category_id', $catId);
    // }
    $result = $query->first();
    if(!empty($result)){
        $return = ['MinPrice'=>$result->Minprice,'MaxPrice'=>$result->MaxPrice];
        return $return;
    }
    // $maxPrice = BandPriceMapping::join('products','band_price_mappings.band_id','products.band_id')->whereColumn('products.min_order_length','>=','band_price_mappings.length')->whereColumn('products.min_order_width','>=','band_price_mappings.width')->whereIn('band_price_mappings.band_id',$bandIds)->selectRaw("band_price_mappings.*,MAX(band_price_mappings.price) AS Maxprice")->first();
    // $totalMaxPrice = ($maxPrice->Maxprice + $result->vat) - $result->discount;

    // print_r($colorIds);exit;
    // if($storeId >0){
    //     $contractIds = Store::where('id', $storeId)->pluck('contract_id')->toArray();
    // }
    // $bandIds = ProductContractMapping::whereIn('contract_id', $contractIds)->pluck('band_id')->toArray();
    // BandPriceMapping::whereIn('band_id',$bandIds)->selectRaw("MIN(band_price_mappings.price) AS Minprice,MAX(band_price_mappings.price) AS Maxprice,product_contract_mappings.discount as contract_discount");
    // $query = Product::whereNull('products.deleted_at')->whereIn('products.id', $productIds)->selectRaw("MIN(band_price_mappings.price) AS Minprice,MAX(band_price_mappings.price) AS Maxprice,product_contract_mappings.discount as contract_discount");
    // $query->join('product_contract_mappings','product_contract_mappings.product_id','products.id');
    // $query->join('band_price_mappings','band_price_mappings.band_id','products.band_id');
    // if($catId > 0 && $catId != 'undefined'){
    //     $query->where('products.category_id',$catId);
    // }
    // if(!empty($colorIds[0])){
    //     $query->whereIn('products.color_id',$colorIds);
    // }
    // $result = $query->first();
    // // echo "<pre>"; print_r($result);exit;
    // return $result;
}

 function getBandMinMaxPrices($id=-1){
    $query = BandPriceMapping::where('band_id',$id)->selectRaw('MIN(band_price_mappings.length) AS Minlength,MIN(band_price_mappings.width) AS Minwidth')->first();
    return $query;
 }

 function getStoreContractProducts($productObj=false,$contractID='',$productID=''){
     $query = Product::select('products.*','band_price_mappings.length as min_product_length','band_price_mappings.length as min_product_width','band_price_mappings.price as min_product_price','product_contract_mappings.discount as contract_discount');
     $query->join('band_price_mappings', function($join){
         $join->on('band_price_mappings.band_id', 'products.band_id');
         $join->on('band_price_mappings.length', 'products.min_order_length');
         $join->on('band_price_mappings.width', 'products.min_order_width');
     });
     $query->join('product_contract_mappings', 'product_contract_mappings.product_id', '=', 'products.id','');
     $query->where('product_contract_mappings.contract_id', $contractID);
     if($productID){
         $query->where('product_contract_mappings.product_id',$productID);
     }
     $query->whereNull('product_contract_mappings.deleted_at');
     $query->groupBy('products.id');
     if ($productObj) {
         $result = $query->get();
     }elseif ($productID){
         $result = $query->first();
     }
     else {
         $result = $query->pluck('id')->toArray();
     }
//    echo "<pre>"; print_r($result);exit;
     return $result;
 }

 function getStoreProductPricing()
 {
     $allstores = getUserStore(true);
     $contractIds = $allstores->pluck('contract_id')->toArray();

     $storeIds = $allstores->pluck('id')->toArray();
     $products = DB::table('products');
     $products->join('store_product_pricing_mappings', 'products.id', '=', 'store_product_pricing_mappings.product_id');
     $products->join('band_price_mappings', function($join){
         $join->on('band_price_mappings.band_id', 'products.band_id');
         $join->on('band_price_mappings.length', 'products.min_order_length');
         $join->on('band_price_mappings.width', 'products.min_order_width');
     });
     $products->join('stores', 'stores.id', '=', 'store_product_pricing_mappings.store_id');
     $products->join('product_contract_mappings', 'store_product_pricing_mappings.product_id', '=', 'product_contract_mappings.product_id');
     $products->join('categories', 'products.category_id', '=', 'categories.id');

     $products->select('products.id','products.name','products.name','products.min_order_length','products.min_order_width','stores.id as store_id','stores.name as StoreName','band_price_mappings.length as min_product_length','band_price_mappings.length as min_product_width','band_price_mappings.price as min_product_price','store_product_pricing_mappings.margin','store_product_pricing_mappings.vat','store_product_pricing_mappings.discount','store_product_pricing_mappings.sale_price', 'store_product_pricing_mappings.id as sppm_id', 'product_contract_mappings.discount as contract_discount');

     //$products->select('products.id','products.name', 'categories.name as category_name', 'products.created_at', 'product_contract_mappings.discount');
     $products->whereIn('product_contract_mappings.contract_id', $contractIds);
     $products->where('products.deleted_at', NULL);
     $products->where('store_product_pricing_mappings.deleted_at', NULL);
     $products->whereIn('store_product_pricing_mappings.store_id', $storeIds);
     $products->groupBy('store_product_pricing_mappings.id');
     $products->orderBy('store_product_pricing_mappings.store_id','DESC');
     $result = $products->get();
     return $result;
 }
 function getAllUsers(){
    $userAll = DB::table('usere');
 }


 function getContractStores($contractObj=false,$contractID='')
 {
      $stores=Store::whereNULL('deleted_at')->where('contract_id',$contractID);
      if($contractObj){
          $result = $stores->get();
      }else{
          $result = $stores->pluck('id')->toArray();
      }
     return $result;


 }

 function getUserWishProducts($storeID)
 {
     $query=Product::select('products.id as product_id','products.main_image','products.name','store_product_pricing_mappings.sale_price','wish_lists.id as WishID');
     $query->join('store_product_pricing_mappings','products.id','store_product_pricing_mappings.product_id');
     $query->join('wish_lists','wish_lists.product_id','store_product_pricing_mappings.product_id');
     $query->whereNull('store_product_pricing_mappings.deleted_at');
     $query->whereNull('products.deleted_at');
     $query->where('store_product_pricing_mappings.store_id',$storeID);
     $query->where('wish_lists.store_id',$storeID);
     $query->where('wish_lists.user_id',Auth::user()->id);
     $query->groupBy('products.id');
     $return = $query->get();
     return $return;
}

function getThemes() {
    $theme = [
        'default' => 'Default Theme'
    ];
    return $theme;
}

function getThemeColors() {
    $colors = [];
    $colors['default'] = [[
        'class' => 'maroon',
        'hex' => '#b21f24',
        'name' => 'Maroon'
    ], [
        'class' => 'dodger_blue',
        'hex' => '#6055ff',
        'name' => 'Dodger Blue'
    ], [
        'class' => 'vermilion',
        'hex' => '#ff4416',
        'name' => 'Vermilion'
    ], [
        'class' => 'jungle_green',
        'hex' => '#28B463',
        'name' => 'Jungle Green'
    ]];
    return $colors;
}

function getDomainSlug($link = "") {
    if($link == "") {
        $link = request()->root();
    }
    $host = parse_url($link)['host'];

    $slug = str_replace('.', '_', $host);
    $return = (object) [
        'host' => $host,
        'slug' => $slug
    ];

    return $return;
}

function getCurrentStore($get = 'store') {
    $domain = getDomainSlug();
    $return = $domain->slug;
    $storeSetting = StoreSetting::where('slug', $domain->slug)->first();
    if(empty($storeSetting)) {
        return false;
    }
    if($get == 'store_setting') {
        $return = $storeSetting;
    } else if($get == 'store') {
        $store = Store::where('id', $storeSetting->store_id)->first();
        $return = $store;
    } else if($get == 'store_id') {
        $return = $storeSetting->store_id;
    }

    return $return;
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreCoverImage;
use App\Models\StoreProductPricingMapping;
use App\Models\StoreSetting;
use App\Models\User;
use App\Models\UserStoreMapping;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->type=='super_admin'){
            $totalUsers=User::whereNotIn('type',['super_admin','customer'])->whereNULL('users.deleted_at')->where('is_active',1)->count();
            $totalStores=Store::whereNULL('deleted_at')->count();
            $totalProducts=Product::whereNULL('deleted_at')->count();
            $totalOrders=Order::whereNULL('deleted_at')->count();
            $totalCustomers=User::whereNULL('deleted_at')->where('type','customer')->count();
        }else{
            $userStores=getUserStore();
            /*$Users=UserStoreMapping::whereIn('user_store_mapping.store_id',$userStores);
            $Users->join('user_store_mappings','users.id','=','user_store_mappings.user_id');
            $Users->whereIn('user_store_mappings.store_id', $userStores);
            $Users->where('user_store_mappings.store_id', $userStores);*/

            $Users=User::whereNULL('users.deleted_at')->whereNotIn('users.type',['super_admin','customer']);
            $Users->join('user_store_mappings','users.id','=','user_store_mappings.user_id');
            $Users->whereIn('user_store_mappings.store_id', $userStores);
            $totalUsers=$Users->count();

            $totalStores=UserStoreMapping::whereIn('store_id',$userStores)->where('user_id',Auth::user()->id)->count();
            $totalProducts=StoreProductPricingMapping::whereNULL('deleted_at')->whereIn('store_id',$userStores)->count();
            $totalOrders=Order::whereNULL('deleted_at')->whereIn('store_id',$userStores)->count();
            $Customers=User::whereNULL('users.deleted_at')->where('type','customer');
            $Customers->join('user_store_mappings','users.id','=','user_store_mappings.user_id');
            $Customers->whereIn('user_store_mappings.store_id', $userStores);
            $totalCustomers=$Customers->count();

        }

       $dt=[
           'totalUsers'=>$totalUsers,
           'totalStores'=>$totalStores,
           'totalProducts'=>$totalProducts,
           'totalCustomers'=>$totalCustomers,
           'totalOrders'=>$totalOrders];

       return view('home',$dt);
    }

    public function homePage()
    {
        $storeSetting = getCurrentStore('store_setting');
        if(empty($storeSetting)) {
            return redirect()->route('home');
        }
        $store = Store::where('id', $storeSetting->store_id)->where('deleted_at', '=', NULL)->first();
     //   $store = getCurrentStore('store_setting');

        if (!empty($store)) {
            $storeProductCategory = getCategory(true, $categoryId = "", $type = "product", $store->id);
            $storeProductColor = getColore(true, $colorId = '', $store->id);
            $storeProductTag = gettags(true, $tagId = '', $store->id);
            isset($storeSetting->id) && !empty($storeSetting->id) ? $storeSettinID=$storeSetting->id : $storeSettinID=NULL;
            $storeImages=StoreCoverImage::where('store_setting_id', $storeSettinID)->whereNULL('deleted_at')->get();
            $dt = [
                'storeProductCategory' => $storeProductCategory,
                'storeProductColor' => $storeProductColor,
                'storeProductTag' => $storeProductTag,
                'store' => $store,
                'storeSetting' => $storeSetting,
                'storeCoverImages' => $storeImages,
            ];

            return view('stores.front.index', $dt);
        } else {
            //Store Not found
            //return redirect()->route('home');
        }
    }
}

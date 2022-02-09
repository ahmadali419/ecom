<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreSetting;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store = getCurrentStore('store');
        //$slug = getCurrentStore('slug');


        //$store = Store::where('slug', $slug)->where('deleted_at', '=', NULL)->first();
        $storeSetting = StoreSetting::where('store_id', $store->id)->first();
        $storeProductCategory = getCategory(true, $categoryId = "", $type = "product", $store->id);
        $storeProductColor = getColore(true, $colorId = '', $store->id);
        $storeProductTag = gettags(true, $tagId = '', $store->id);
        $wishList=getUserWishProducts($store->id);
        $dt = ['storeProductCategory' => $storeProductCategory, 'storeProductColor' => $storeProductColor, 'storeProductTag' => $storeProductTag, 'storeSetting' => $storeSetting, 'store' => $store,'wishList'=>$wishList];

        return view('whishlists.list', $dt);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->value=='false'){
            $res = WishList::where('product_id',$request->product_id)->where('store_id',$request->store_id)->where('user_id',Auth::user()->id)->first();
            if($res){
                $res->delete();
                $return=['status' => 'success', 'message' => 'product remove from wish list'];
            }else{
                $return=['status' => 'error', 'message' => 'something wrong please try again!'];
            }

        }
        else{

            $wish=new WishList();
            $wish->product_id=$request->product_id;
            $wish->user_id=Auth::user()->id;
            $wish->store_id=$request->store_id;
            $qry=$wish->save();
            if($qry){
                $return=['status'=>'success','message'=>'product add in wish list'];
            }else{
                $return=['status'=>'error','message'=>'something wrong please try again'];
            }

        }

        return response()->json($return);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WishList  $whishList
     * @return \Illuminate\Http\Response
     */
    public function show(WishList $whishList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WishList  $whishList
     * @return \Illuminate\Http\Response
     */
    public function edit(WishList $whishList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WishList  $whishList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WishList $whishList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WishList  $whishList
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->wishID;
        $res = WishList::find($id);
        if ($res) {
            $res->delete();
            return response()->json(['status' => 'success', 'message' => 'Product remove from wishlist successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'product not deleted from wishlist']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Contract;
use App\Models\Product;
use App\Models\StoreCoverImage;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
use App\Models\Role;
use App\Models\StoreProductPricingMapping;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Str;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contracts = getContracts();
        $dt = [
            'contracts' => $contracts
        ];
        return view('stores.list', $dt);
    }


    public function getList(Request $request)
    {
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $storeIDS = getUserStore();
        //$userId = auth()->user()->id;
        $stores = DB::table('stores')->join('contracts', 'stores.contract_id', '=', 'contracts.id')->select('stores.id', 'stores.name', 'contracts.name as contract_name', 'stores.address', 'stores.created_at');
        if (Auth::user()->type == 'shop' or Auth::user()->type == 'employee') {
            $stores->whereIn('stores.id', $storeIDS);
        }
        $stores->where('stores.deleted_at', NULL);
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'Name') {
                    $col1 = 'stores.name';
                    $stores->where($col1, 'like', '%' . $search . '%');
                }
                if ($col == 'contract_name') {
                    $col2 = 'contract_id';
                     $stores->where($col2, 'like', '%' . $search . '%');
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $stores->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $stores->orderBy("name", "desc");
        }
        $iTotalRecords = $stores->count();
        $stores->skip($start);
        $stores->take($length);
        $storeData = $stores->get();
        $data = [];
        $i = 1;
        foreach ($storeData as $storeObj) {
            $action = "";
            $action .= '<a href="' . route('setting.index', ['id' => $storeObj->id]) . '" class="btn btn-sm btn-clean btn-icon"  title="Settings">
            <i class="la la-cog"></i>
        </a>';
            $action .= '<a href="javascript:;"  class="btn btn-sm btn-clean btn-icon edit" data-id="' . $storeObj->id . '" title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $storeObj->id . '" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';

            $data[] = [
                "id" => $i,
                "Name" => $storeObj->name,
                "contract_name" => $storeObj->contract_name,
               // "contract_id" => $storeObj->contract_id,
                "Address" => $storeObj->address,
                "created_at" => Carbon::create($storeObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "action" => $action
            ];
            $i++;
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        echo json_encode($records);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $previousContractID = 0;
        $id = $request->id;
        $store = new Store();
        if ($id > 0) {
            $store = Store::findOrFail($id);
            $previousContractID = $store->contract_id;
        }
        $store->name = $request->name;
        //$store->slug = Str::slug($request->name, '-');
        $store->contract_id = $request->contract_id;
        $store->address = $request->address;
        $store->added_by = Auth::user()->id;
        $query = $store->save();
        if ($previousContractID > 0 && $previousContractID != $request->contract_id) {

            $contractProducts = getStoreContractProducts(true, $request->contract_id);

            if (!empty($contractProducts)) {

                $res = StoreProductPricingMapping::where('store_id', $store->id);
                if ($res) {
                    $res->update(array('deleted_at' => DB::raw('NOW()')));

                }
                $contractProductsNew = array();
                foreach ($contractProducts as $contractProduct) {
                    $overAllPrice = overallProductPrice($contractProduct->min_product_price, -1, $contractProduct->contract_discount);
                    $contractProductsNew[] = array(
                        'store_id' => $store->id,
                        'product_id' => $contractProduct->id,
                        'sale_price' => $overAllPrice,
                        'created_at' => Carbon::now()->format('Y-m-d'),
                    );

                }

                $qry = StoreProductPricingMapping::insert($contractProductsNew);
                if ($qry) {
                    $return = [
                        'status' => 'success',
                        'message' => 'Contract Assigned to this store  successfully',
                    ];
                } else {
                    $return = [
                        'status' => 'error',
                        'message' => 'Store is not save successfully',
                    ];
                }


            }

        } else if ($id == '') {

            $role=New Role;
            $role->name='customer';
            $role->store_id=$store->id;
            $queryrole = $role->save();

            $contractProducts = getStoreContractProducts(true, $request->contract_id);

            if (!empty($contractProducts)) {

                $res = StoreProductPricingMapping::where('store_id', $store->id);
                if ($res) {
                    $res->update(array('deleted_at' => DB::raw('NOW()')));

                }
                $contractProductsNew = array();
                foreach ($contractProducts as $contractProduct) {
                    $overAllPrice = overallProductPrice($contractProduct->min_product_price, -1, $contractProduct->contract_discount);
                    $contractProductsNew[] = array(
                        'store_id' => $store->id,
                        'product_id' => $contractProduct->id,
                        'sale_price' => $overAllPrice,
                        'created_at' => Carbon::now()->format('Y-m-d'),

                    );

                }

                $qry = StoreProductPricingMapping::insert($contractProductsNew);
                if ($qry) {
                    $return = [
                        'status' => 'success',
                        'message' => 'Contract Assigned to this store  successfully',
                    ];
                } else {
                    $return = [
                        'status' => 'error',
                        'message' => 'Store is not save successfully',
                    ];
                }


            }


        } else {
            $return = [
                'status' => 'error',
                'message' => 'Store is not save successfully',
            ];
            if ($query) {
                $return = [
                    'status' => 'success',
                    'message' => 'Store is save successfully',
                ];
            }

        }

        return response()->json($return);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function getStoreById(Request $request)
    {
        $id = $request->id;
        $store = Store::where('id', $id)->first();
        $return = [
            'status' => 'success',
            'data' => $store
        ];
        if (empty($store)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit'
            ];
        }
        return response()->json($return);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Store $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        //echo $id;exit;

        $res = Store::find($id);
        if ($res) {
            $res->delete();
            return response()->json(['status' => 'success', 'message' => 'Store is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Store not deleted beacuse it is assigned']);
        }
    }

    public function getProduct(Request $request)
    {
        //echo "fdsfsddsf";exit;
        $allstores = getUserStore(true);
        $charges = Charge::where('deleted_at', '=', NULL)->get();
        $contractIds = $allstores->pluck('contract_id')->toArray();
        $dt = [
            'allstores' => $allstores,
            'contractIds' => $contractIds,
            'charges' => $charges,
        ];
        return view('stores.product_list', $dt);
    }

    public function getProductList(Request $request)
    {
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnName = 'products.name';
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $allstores = getUserStore(true);
        $contractIds = $allstores->pluck('contract_id')->toArray();
        $storeIds = $allstores->pluck('id')->toArray();

        $products = DB::table('products')
            ->join('store_product_pricing_mappings', 'products.id', '=', 'store_product_pricing_mappings.product_id')
            ->join('product_contract_mappings', 'store_product_pricing_mappings.product_id', '=', 'product_contract_mappings.product_id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.id', 'products.name', 'categories.name as category_name', 'products.created_at', 'product_contract_mappings.discount', 'store_product_pricing_mappings.store_id');
        $products->whereIn('product_contract_mappings.contract_id', $contractIds);
        $products->where('products.deleted_at', NULL);
        $products->where('store_product_pricing_mappings.deleted_at', NULL);
        $products->whereIn('store_product_pricing_mappings.store_id', $storeIds);
        $products->groupBy('product_contract_mappings.id');
        $products->orderBy('store_product_pricing_mappings.id', 'DESC')->get();

        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {

                if ($col == 'Name') {
                    $col1 = 'products.name';
                    $products->where($col1, 'like', '%' . $search . '%');
                }
                if ($col == 'Category') {
                    $col1 = 'categories.name';
                    $products->where($col1, 'like', '%' . $search . '%');
                }
                if ($col == 'Discount %') {
                    $col1 = 'store_product_pricing_mappings.store_id';
                    $products->where($col1, '=', $search);
                }
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $products->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $products->orderBy("products.name", "desc");
        }
        // $products->groupBy('products.id');
        $iTotalRecords = $products->count();
        $products->skip($start);
        $products->take($length);
        $productData = $products->get();

        $data = [];
        $i = 1;
        foreach ($productData as $productObj) {

            $action = "";

            $action .= '<a href="' . route('product.preview',['id' => $productObj->id]) . '" class="btn btn-sm btn-clean btn-icon edit"  title="preview product">
                            <i class="la la-eye"></i>
                        </a>';
            $action .= '<a href="javascript:;" data-product_id="' . $productObj->id . '" data-store_id="' . $productObj->store_id . '" class="btn btn-sm btn-clean btn-icon show_pricing"  title="Product Pricing">
                            <i class="la la-money"></i>
                        </a>';
            $data[] = [
                "Sr" => $i,
                "Name" => $productObj->name,
                "Category" => $productObj->category_name,
                "Discount % " => $productObj->discount . '%',
                "action" => $action
            ];
            $i++;
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);
    }

    public function storeSlug()
    {

        $store = getCurrentStore('store');
        //$store = Store::where('slug', $slug)->where('deleted_at', '=', NULL)->first();
        if (!empty($store)) {
            $storeSetting = StoreSetting::where('store_id', $store->id)->first();
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
            return redirect('/');
        }
    }

    public function storeProduct(Request $request, $categoryID)
    {
        $domain = getDomainSlug();
        $storeSetting = StoreSetting::where('slug', $domain->slug)->first();
        if(empty($storeSetting)) {
            return redirect()->route('home');
        }
        $store = getCurrentStore('store');

       // $store = Store::where('id', $storeSetting->store_id)->first();
        if (!empty($store)) {
            $storeSetting = StoreSetting::where('store_id', $store->id)->first();
            $storeProductCategory = getCategory(true, $categoryId = "", $type = "product", $store->id);
            $storeProductColor = getColore(true, $colorId = '', $store->id);
            $storeProductTag = gettags(true, $tagId = '', $store->id);
            $result = getProductByCategory($categoryID, -1, -1, $store->id);
            $filterPrices = getFilterPrices($categoryID, $store->id);
            // print_r($filterPrices['MinPrice']);exit;
            $dt = ['products' => $result, 'storeProductCategory' => $storeProductCategory, 'storeProductColor' => $storeProductColor, 'storeProductTag' => $storeProductTag, 'storeSetting' => $storeSetting, 'store' => $store, 'filterPrices' => $filterPrices];
            //return view('web.category_products.index',$dt);
            return view('stores.front.products', $dt);
        } else {
            return redirect('/');
        }
    }

    public function storeProductPagniate(Request $request)
    {

        $categoryId = $request->category_id;
        // echo $categoryId;exit;
        // $paginate = $request->page;
        // echo $paginate;exit;
        $domain = getDomainSlug();
        $storeSetting = StoreSetting::where('slug', $domain->slug)->first();
        if(empty($storeSetting)) {
            return redirect()->route('home');
        }
        $store = Store::where('id', $storeSetting->store_id)->first();
        if (!empty($store)) {
            // isset($paginate) && !empty($paginate) ? $paginate : $paginate = 1;
            if ($categoryId > 0) {
                $filterPrices = getFilterPrices($request->category_id, $store->id);
                $productCategory = getCategory(true, $categoryId = "", $type = "product", $store->id);
                $result = getProductByCategory(!empty($request->category_id) ? $request->category_id : '', -1, -1, $store->id, -1);
                $totalProducts = $result->count();
            } else {
                $filterPrices = getFilterPrices(!empty($request->catId) ? $request->catId : -1, $store->id);
                $result = getProductByCategory(-1, -1, -1, $store->id);
                $totalProducts = $result->count();
            }
            $dt = [
                'productsData' => $result,
                'store' => $store,
            ];
            $html = view('stores.front.ajax.filter_products', $dt)->render();
            $response = [
                'status' => 'success',
                'filterPrices' => $filterPrices,
                'totalProducts' => $totalProducts,
                'html' => $html
            ];

            return response()->json($response);
        } else {
            return redirect('/');
        }
    }

    public function storeProductColor($colorID)
    {
        $domain = getDomainSlug();
        $storeSetting = StoreSetting::where('slug', $domain->slug)->first();
        if(empty($storeSetting)) {
            return redirect()->route('home');
        }
        $store = Store::where('id', $storeSetting->store_id)->first();
        if (!empty($store)) {
            $storeSetting = StoreSetting::where('store_id', $store->id)->first();
            $storeProductCategory = getCategory(true, $categoryId = "", $type = "product", $store->id);
            $storeProductColor = getColore(true, $colorId = '', $store->id);
            $storeProductTag = gettags(true, $tagId = '', $store->id);
            $filterPrices = getFilterPrices(!empty($categoryId) ? $categoryId : -1, $store->id);
            $result = getProductByCategory(-1, $colorID, -1, $store->id);
            $dt = ['products' => $result, 'storeProductCategory' => $storeProductCategory, 'storeProductColor' => $storeProductColor, 'storeProductTag' => $storeProductTag, 'storeSetting' => $storeSetting, 'store' => $store, 'filterPrices' => $filterPrices];
            //return view('web.category_products.index',$dt);
            return view('stores.front.products', $dt);
        } else {
            return redirect('/');
        }
    }

    public function storeProductTag($tagID)
    {
        $domain = getDomainSlug();
        $storeSetting = StoreSetting::where('slug', $domain->slug)->first();
        if(empty($storeSetting)) {
            return redirect()->route('home');
        }
        $store = Store::where('id', $storeSetting->store_id)->first();
        if (!empty($store)) {
            $storeSetting = StoreSetting::where('store_id', $store->id)->first();
            $storeProductCategory = getCategory(true, $categoryId = "", $type = "product", $store->id);
            $storeProductColor = getColore(true, $colorId = '', $store->id);
            $storeProductTag = gettags(true, $tagId = '', $store->id);
            $result = getProductByCategory(-1, -1, $tagID, $store->id);
            $dt = ['products' => $result, 'storeProductCategory' => $storeProductCategory, 'storeProductColor' => $storeProductColor, 'storeProductTag' => $storeProductTag, 'storeSetting' => $storeSetting, 'store' => $store];
            //return view('web.category_products.index',$dt);
            return view('stores.front.products', $dt);
        } else {
            return redirect('/');
        }
    }

    public function storeProductDetail($productID)
    {
        $store = getCurrentStore('store');
        //$store = Store::where('slug', $slug)->where('deleted_at', '=', NULL)->first();
        $productIDs = getContractProducts($store->contract_id);
        if (!empty($store) && in_array($productID, $productIDs)) {
            $storeSetting = StoreSetting::where('store_id', $store->id)->first();
            $storeProductCategory = getCategory(true, $categoryId = "", $type = "product", $store->id);
            $storeProductColor = getColore(true, $colorId = '', $store->id);
            $storeProductTag = gettags(true, $tagId = '', $store->id);
            $result = getProductByID($productID, $store->contract_id, -1, $store->id);

            $relatedProducts = array();
            isset($result->category_id) && !empty($result->category_id) ? $categoryID = $result->category_id : $categoryID = -1;

            if ($categoryID > 0) {
                $relatedProducts = getRelatedProduct($productID, $store->contract_id, $categoryID, $store->id);
            }

            $dt = ['singleProduct' => $result, 'storeProductCategory' => $storeProductCategory, 'storeProductColor' => $storeProductColor, 'storeProductTag' => $storeProductTag, 'storeSetting' => $storeSetting, 'store' => $store, 'relatedProducts' => $relatedProducts];
            return view('stores.front.products_detail', $dt);
        } else {
            return redirect()->back()->with('error', 'ERROR: product not assigned to this store!');
        }
    }

    public function storeProductQuote($productID, Request $request)
    {
        $store = getCurrentStore('store');
        //$store = Store::where('slug', $slug)->where('deleted_at', '=', NULL)->first();
        $productIDs = getContractProducts($store->contract_id);
        if (!empty($store) && in_array($productID, $productIDs)) {
            $productInfo = getProductByID($productID, $store->contract_id, '-1', $store->id);
            //echo "<pre>";print_r($productInfo);exit;
            $width = $request->width_measure;
            $height = $request->height_measure;
            $minorderheight = $productInfo->min_order_length;
            $minorderwidth = $productInfo->min_order_width;

            if ($request->measure == 'cm') {
                $width = $request->width_measure / 2.54;
                $height = $request->height_measure / 2.54;
            }
            if ($request->measure == 'mm') {
                $width = $request->width_measure / 25.4;
                $height = $request->height_measure / 25.4;
            }
            if ($width >= $minorderwidth && $height >= $minorderheight) {
                $result = calculateProductQuote($productID, $width, $height);
                if ($result) {
                    $bandPrice = $result->price;
                    $additionalCharges = getProductAdditionalCharges($productID, $store->id);
                    //echo "<pre>";print_r($bandPrice);exit;
                    $contractDiscount = $productInfo->discount;
                    $scale = $request->measure;
                    $totalPrice = overallProductPrice($bandPrice, $additionalCharges, $contractDiscount);


                    return response()->json(['status' => 'success', 'price' => $totalPrice]);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'we can\'t make this product in those sizes']);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'we can\'t make this product in those sizes']);
            }

        } else {
            return response()->json(['status' => 'error', 'message' => 'you can\'t access this store product price']);
        }

    }

    public function addToCart(Request $request, $productID, $variant_id = 0)
    {

        $store = getCurrentStore('store');
       // $store = Store::where('slug', $slug)->where('deleted_at', '=', NULL)->first();
        $productIDs = getContractProducts($store->contract_id);

        if (!empty($store) && in_array($productID, $productIDs)) {
            $productInfo = getProductByID($productID, $store->contract_id);
            $cart = [];
            //$cart = getCurrentStore('slug');
            $slug = getCurrentStore('slug');
            $dim = $request->height_measure . 'x' . $request->width_measure;
            $cart[$productID][$dim] = [
                "store_id" => $store->id,
                "product_id" => $productID,
                "product_name" => $productInfo->name,
                "image" => asset('product/coverimage') . '/' . $productInfo->main_image,
                "price" => $request->total_price,
                "measure" => $request->measure,
                "height" => $request->height_measure,
                "width" => $request->width_measure,
                "fitting" => $request->fitting,
                "scale" => $request->scale,
                "quantity" => '1',
                "set_fitting" => $request->set_fitting,
                "side_control" => $request->side_control,
                "chain_color" => $request->chain_color,
                "added_on" => Carbon::now()->format('Y-m-d')
            ];

            session()->put($slug, $cart);

            $counts = 0;
            if (!empty($cart) && count($cart) > 0) {
                foreach ($cart as $productIds => $arr) {
                    if (!empty($arr)) {
                        $kk = $productIds;
                        $counts++;
                    }
                }
            }
            return response()->json(
                [
                    'code' => 200,
                    'status' => 'success',
                    'message' => $productInfo->name . __('added to cart successfully!'),
                    'cart' => $cart,
                    'quantity' => $counts,
                ]
            );


        } else {
            return response()->json(['status' => 'error', 'message' => 'you can\'t access this store product price']);
        }
    }

    public function getStoreCart(Request $request)
    {
        $slug = getCurrentStore('slug');
       // $slug = $request->slug;
        $id = $request->id;
        $dim = $request->dim;
        if (!empty($dim) && $id > 0) {
            $cart = session()->get($slug);
            unset($cart[$id][$dim]);
            session()->put($slug, $cart);

        }
        $dt = [
            'slug' => $slug
        ];
        $html = view('stores.front.ajax.store_cart', $dt)->render();
        $return = [
            'html' => $html,
            'cart_count' => 1
        ];
        return $return;

    }

    public function removesCartItem(Request $request)
    {
        $slug = getCurrentStore('slug');
        //$slug = $request->slug;
        $id = $request->id;
        $dim = $request->dim;
        if (!empty($dim) && $id > 0) {
            $cart = session()->get($slug);
            unset($cart[$id][$dim]);
            session()->put($slug, $cart);
        }
        $return = [
            'status' => 'success',
            'message' => 'Cart item remove successfully',
            'quantity' => count($cart),
        ];
        return $return;
    }

    public function quantityCart(Request $request)
    {
        $slug = getCurrentStore('slug');
       // $slug = $request->slug;
        $id = $request->id;
        $dim = $request->dim;
        $qty = $request->qty;

        if (!empty($dim) && $id > 0) {
            $cart = session()->get($slug);
            $store = Store::where('id', $cart[$id][$dim]['store_id'])->where('deleted_at', '=', NULL)->first();
            $productInfo = getProductByID($cart[$id][$dim]['product_id'], $store->contract_id, '-1', $store->id);


            $width = $cart[$id][$dim]['width'];
            $height = $cart[$id][$dim]['height'];
            if ($cart[$id][$dim]['scale'] == 'cm') {
                $width = $cart[$id][$dim]['width'] / 2.54;
                $height = $cart[$id][$dim]['height'] / 2.54;
            }
            if ($cart[$id][$dim]['scale'] == 'mm') {
                $width = $cart[$id][$dim]['width'] / 25.4;
                $height = $cart[$id][$dim]['height'] / 25.4;
            }
            $result = calculateProductQuote($cart[$id][$dim]['product_id'], $width, $height);
            $bandPrice = $result->price;

            $additionalCharges = getProductAdditionalCharges($cart[$id][$dim]['product_id'], $store->id);
            $contractDiscount = $productInfo->discount;
            $totalPrice = overallProductPrice($bandPrice, $additionalCharges, $contractDiscount);
            $cart[$id][$dim]['quantity'] = $qty;
            $cart[$id][$dim]['price'] = $qty * $totalPrice;
            session()->put($slug, $cart);
        }
        $return = [
            'status' => 'success',
            'message' => 'Cart item add successfully'
        ];
        return $return;
    }

    public function viewCart()
    {
        $store = getCurrentStore('store');
        //$store = Store::where('slug', $slug)->where('deleted_at', '=', NULL)->first();
        $storeSetting = StoreSetting::where('store_id', $store->id)->first();
        $storeProductCategory = getCategory(true, $categoryId = "", $type = "product", $store->id);
        $storeProductColor = getColore(true, $colorId = '', $store->id);
        $storeProductTag = gettags(true, $tagId = '', $store->id);
        $dt = ['store' => $store, 'storeSetting' => $storeSetting, 'storeProductCategory' => $storeProductCategory, 'storeProductColor' => $storeProductColor, 'storeProductTag' => $storeProductTag];
        return view('stores.front.view_cart', $dt);
    }


    public function storeProductShow ($productID)
    {
        $store = getCurrentStore('store');
        //$store = Store::where('slug', $slug)->where('deleted_at', '=', NULL)->first();
        $productIDs = getContractProducts($store->contract_id);
        if (!empty($store) && in_array($productID, $productIDs)) {
            $result = getProductByID($productID, $store->contract_id, $store->id);
            return response()->json(['status' => 'success', 'produc_detail' => $result, 'total_price' => $result->sale_price, 'main_image' => asset('product/coverimage') . '/' . $result->main_image]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'you can\'t access this store product detail']);
        }
    }


    public function cartCheckout()
    {
        $store = getCurrentStore('store');
        $slug = getCurrentStore('slug');
       // $store = Store::where('slug', $slug)->where('deleted_at', '=', NULL)->first();
        $storeSetting = StoreSetting::where('store_id', $store->id)->first();
        $storeProductCategory = getCategory(true, $categoryId = "", $type = "product", $store->id);
        $storeProductColor = getColore(true, $colorId = '', $store->id);
        $storeProductTag = gettags(true, $tagId = '', $store->id);
        $dt = ['store' => $store, 'storeSetting' => $storeSetting, 'storeProductCategory' => $storeProductCategory, 'storeProductColor' => $storeProductColor, 'storeProductTag' => $storeProductTag];
        return view('stores.front.checkout', $dt);
    }

    public function productPricing()
    {
        $allProducts = getStoreProductPricing();
        $dt = ['allProducts' => $allProducts];
        return view('products.pricing', $dt);
    }

    public function StoreProductSellingPrice(Request $request)
    {
        $sppmIds = $request->sppm_id;
        $buyingPrices = $request->buy_price;
        $margins = $request->margin;
        $vats = $request->vat;
        $discounts = $request->discount;
        $salePrices = $request->sale_price;
        if(!empty($sppmIds)) {
            foreach($sppmIds as $sppmId) {
                $update = [
                    'margin' => $margins[$sppmId],
                    'vat' => $vats[$sppmId],
                    'discount' => $discounts[$sppmId],
                    'sale_price' => $salePrices[$sppmId],
                ];
                StoreProductPricingMapping::where('id', $sppmId)->update($update);
            }
        }
        $return = [
            'status' => 'success',
            'message' => 'Pricing save successfuly!'
        ];
        return response()->json($return);
    }

    public function storePages($page)
    {
        //echo $page;exit;
        $store = getCurrentStore('store');
        $slug = getCurrentStore('slug');
        //$store = Store::where('slug', $slug)->where('deleted_at', '=', NULL)->first();
        if (!empty($store)) {
            $storeSetting = StoreSetting::where('store_id', $store->id)->first();
            $storeProductCategory = getCategory(true, $categoryId = "", $type = "product", $store->id);
            $storeProductColor = getColore(true, $colorId = '', $store->id);
            $storeProductTag = gettags(true, '', $store->id);
            $result = StoreSetting::where('store_id', $store->id)->select($page)->first();
            $dt = ['pageinfo' => $result,'pageName'=>$page, 'storeProductCategory' => $storeProductCategory, 'storeProductColor' => $storeProductColor, 'storeProductTag' => $storeProductTag, 'storeSetting' => $storeSetting, 'store' => $store];
             //return view('web.category_products.index',$dt);
            return view('stores.front.page', $dt);
        } else {
            return redirect('/');
        }
    }
}

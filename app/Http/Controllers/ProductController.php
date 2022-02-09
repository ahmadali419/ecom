<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allstores = getUserStore(true);
        $dt = [
            'allstores' => $allstores
            ];
        return view('products.list' , $dt);
    }
    public function getList(Request $request)
    {
        // echo "yes";exit;

        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;

        $userId = auth()->user()->id;
        $products = DB::table('products')->join('categories', 'products.category_id', '=', 'categories.id')->select('products.id', 'products.name', 'categories.name as category_name', 'products.created_at');
        $products->where('products.deleted_at', NULL);
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
            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $products->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $products->orderBy("name", "desc");
        }
        $iTotalRecords = $products->count();
        $products->skip($start);
        $products->take($length);
        $productData = $products->get();
        $data = [];
        $i = 1;
        foreach ($productData as $productObj) {
            $action = "";

            $action .= '<a href="' . route('product.edit',['id' => $productObj->id]) . '" class="btn btn-sm btn-clean btn-icon edit"  title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';


            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $productObj->id . '" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';

            $data[] = [
                "id" => $i,
                "Name" => $productObj->name,
                "category_id" => $productObj->category_name,
                "created_at" => Carbon::create($productObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
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
        //$type = 'product';
        $category = getCategory(true);
        $color = getColore(true);
        $charges = getcharges(true);
        $tag = gettags(true);
        $bands = getbands(true);


        $res = [
            'category' => $category,
            'color' => $color,
            'charges' => $charges,
            'tags' => $tag,
            'bands' => $bands,
        ];
        return view('products.create', $res);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = true;
        $validateInput = $request->all();

        $rules = [
            'name' => 'required',
            'sku' => 'required',
            'feature.*' => 'required',
            'summernote' => 'required',
            'image_cover' => 'required_without:product_id',
            'images.*' => 'required_without:id',
            'tags.*' => 'required',
            'category_id' => 'required',
            'color' => 'required',
            // 'band_id'=>'required',
            // 'min_order_len'=>'required',
            // 'min_order_wid'=>'required',


        ];

        $messages = [

            'image_cover.required_without' => 'image is required!',
            'images.*.required_without' => 'product image is required!',
            'sku.required' => 'sku is required!',
            'name.required' => 'product is required!',
            'summernote.required' => 'description is required!',
            'feature.*.required' => 'feature is required!',
            'tags.*.required' => 'tags is required!',
            'category_id.required' => 'category is required!',
            'color.required' => 'category is required!',
            'band_id.required' => 'band is required!',
            'min_order_len.required' => 'set min order is required!',
            'min_order_wid.required' => 'set min order is required!',


        ];
        $validator = Validator::make($validateInput, $rules, $messages);
        if ($validator->fails()) {

            $errors = $validator->errors();
            $allMsg = [];
            foreach ($errors->all() as $message) {
                $allMsg[] = $message;
            }
            $return['status'] = 'error';
            $return['message'] = collect($allMsg)->implode('<br />');
            $validate = false;
        }
        if ($validate) {
            $length = $request->min_order_len;
            $width = $request->min_order_wid;
            $minLength = $request->min_length;
            $minWidth = $request->min_width;

            $id = $request->product_id;
            if ($id != '' && $id != '-1') {
                $productObj = Product::find($id);
            } else {
                $productObj = new Product();
            }
            if ($request->hasFile('image_cover')) {
                $productAttach = $request->file('image_cover');
                $productAttachName = uniqid() . '.' . $request->image_cover->getClientOriginalExtension();
                $request->image_cover->move(public_path('product/coverimage'), $productAttachName);
                $productObj->main_image = $productAttachName;
                if (\File::exists(public_path('product/coverimage/' . $request->old_image))) {
                    \File::delete(public_path('product/coverimage/' . $request->old_image));
                }
            }

            $title = preg_replace("/[^a-zA-Z]+/", " ", $request->name);
            $productObj->name = $title;
            $productObj->slug = Str::slug($title, '-');;
            $productObj->category_id = $request->category_id;
            $productObj->sku = $request->sku;
            $productObj->color_id = $request->color;
            $productObj->band_id = $request->band_id;
            $productObj->min_order_length = $request->min_order_len;
            $productObj->min_order_width = $request->min_order_wid;
           // $productObj->charge_id = $request->charges_type;
            //$productObj->charges_price = $request->charges;
            $productObj->features = serialize($request->feature);
            $productObj->description = json_encode($request->summernote);
            $productObj->created_by = Auth::user()->id;
            $productObj->created_at = Carbon::now()->format("Y-m-d H:i:s");
            $query = $productObj->save();
            $productID = $productObj->id;
            if ($productID > 0) {
                $productTags = saveProductTags($productID, $request->tags);
                $productImages = $request->images;
                /*if (!empty($productImages)) {
                    $oldImages = ProductImage::where('product_id',$productID)->get(['image']);
                    // print_r($oldImages);exit;
                    foreach ($oldImages as $imgObj) {
                        $path = public_path('product/productimages/').$imgObj->image;
                        if (file_exists($path)) {
                            unlink($path);
                        }
                    }
                    ProductImage::where('product_id', $productID)->delete();
                }*/
                // print_r($productImages);exit;
                if (!empty($productImages)) {
                    $productmulti = array();
                    foreach ($productImages as $key => $file) {
                        if ($request->images != '') {
                            if ($file) {
                                $filenameWithExt = $file->getClientOriginalName();
                                $passportFile = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                                $extension = $file->getClientOriginalExtension();
                                $input['images'] = $passportFile . '_' . time() . '.' . $extension;
                                $destinationPath = public_path('product/productimages/');
                                $file->move($destinationPath, $input['images']);
                            }

                            $productmulti[] = [
                                'product_id' => $productID,
                                'image' => $input['images'],
                                'created_by' => Auth::user()->id,
                            ];
                        }
                    }
                    DB::table('product_images')->insert($productmulti);
                }
                $return = [
                    'status' => 'success',
                    'message' => 'Product is save successfully',
                ];
            } else {
                $return = [
                    'status' => 'error',
                    'message' => 'Product is not saved successfully',
                ];
            }
        }
        return response()->json($return);
    }

    public function getAllProducts()
    {

        $products = Product::all();
        if (!($products->isEmpty())) {
            $dt = ['status' => 'success', 'products' => $products];
        } else {
            $dt = ['status' => 'error', 'message' => 'No Product Found!'];
        }
        return response()->json($dt);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($productID)
    {

        $category = getCategory(true);
        $color = getColore(true);
        $charges = getcharges(true);
        $tag = gettags(true);
        $bands = getbands(true);
        $singleProduct = Product::with('product_images')->with('product_tags')->where('id', '=', $productID)->where('deleted_at', '=', NULL)->first();
        /*echo "<pre>";
        print_r($singleProduct);
        echo "</pre>";
        die;*/
        $res = [
            'category' => $category,
            'color' => $color,
            'charges' => $charges,
            'tags' => $tag,
            'bands' => $bands,
            'singleProduct' => $singleProduct
        ];


        return view('products.create', $res);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        //echo $id;exit;

        $res = Product::find($id);
        if ($res) {
            $res->delete();
            return response()->json(['status' => 'success', 'message' => 'Product is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Product not deleted try again ']);
        }
    }
    public function removeImage(Request $request)
    {
        $id = $request->id;
        $res = ProductImage::find($id);
        $path = public_path('product/productimages/').$res->image;
        if (file_exists($path)) {
            unlink($path);
        }
        if ($res) {
            $res->delete();
            return response()->json(['status' => 'success', 'message' => 'Product image is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Product image not deleted try again ']);
        }
    }

    public function previewProduct($productID)
    {
        $singleProduct = Product::with('product_images')->with('product_tags')->with('product_color')->with('product_category')->where('id', '=', $productID)->where('deleted_at', '=', NULL)->first();
        $res = [
            'singleProduct' => $singleProduct
        ];
        return view('products.preview', $res);
    }


    public function getBandMinMaxPrices(Request $request){
      $prices =  getBandMinMaxPrices($request->id);
      if(!empty($prices)){
          $return = ['status'=>'success','prices'=>$prices];
          return response()->json($return);
      }
    }

}

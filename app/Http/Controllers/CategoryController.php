<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Store;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\Validator;
use Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $types = getCategoryTypes();
        $categories = getCategory([], true);
        $dt = [
            'types' => $types,
            'categories' => $categories
        ];
        return view('categories.list', $dt);
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
        $userId = auth()->user()->id;
        $category = DB::table('categories')->where('type', '=', 'product')->whereNull('deleted_at');
        //        if($type != 'super_admin') {
        //            $category->whereRaw('FIND_IN_SET(?,branch_id)',$userBranchIds);
        //        }
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                // if ($col == 'id') {
                //     $category->where($col, $search);
                // }
                if ($col == 'name') {
                    $category->where($col, 'like', '%' . $search . '%');

                }
                if ($col == 'created_at') {
                    $dateArr = explode('|', $search);
                    $dateFrom = Carbon::create($dateArr[0] . " 00:00:00")->format('Y-m-d H:i:s');
                    $dateTo = Carbon::create($dateArr[1] . " 23:59:59")->format('Y-m-d H:i:s');
                    $category->whereBetween('created_at', [$dateFrom, $dateTo]);
                }
            }
        }

        $iTotalRecords = $category->count();
        $category->skip($start);
        $category->take($length);

        $categoryData = $category->get();
        $data = [];
        $i =1;
        foreach ($categoryData as $categoryObj) {
            $action = "";

            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon edit" data-id="' . $categoryObj->id . '" title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';


            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $categoryObj->id . '" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';

            $data[] = [
                "sr" => $i,
                "name" => $categoryObj->name,
                "created_at" => Carbon::create($categoryObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
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

    public function store(Request $request)
    {
        $id = $request->id;
        $validate = true;
        $validateInput = $request->all();
        $rules = [
            'name' => 'required|max:150',
            'id' => 'max:150',
        ];
        if (!empty($id)) {
            $rules = [
                'old_image' => 'required',

            ];
        }
        if (empty($id)) {
            $rules = [
                'category_logo' => 'required|image',

            ];
        }
        $validator = Validator::make($validateInput, $rules);
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

            $category = new Category();
            if ($id > 0) {
                $category = Category::findOrFail($id);
            }
            if ($request->hasFile('category_logo')) {
                $userAttach = $request->file('category_logo');
                $logoAttach = uniqid() . '.' . $request->category_logo->getClientOriginalExtension();
                $request->category_logo->move(public_path('category/'), $logoAttach);
                $category->image = $logoAttach;
                if (\File::exists(public_path('category/' . $request->old_image))) {
                    \File::delete(public_path('category/' . $request->old_image));
                }
            }
            $category->name = $request->name;
            $category->added_by = Auth::user()->id;
            $query = $category->save();
            $return = [
                'status' => 'error',
                'message' => 'Category is not save successfully',
            ];
            if ($query) {
                $return = [
                    'status' => 'success',
                    'message' => 'Category is save successfully',
                    'catogeryId' => $category->id,
                ];
            }
        }

        return response()->json($return);
    }

    public function getCategoryById(Request $request)
    {
        $id = $request->id;
        $category = Category::where('id', $id)->first();
        $return = [
            'status' => 'success',
            'data' => $category,
            'image_path' => asset('category') . '/' . $category->image
        ];
        if (empty($category)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit',

            ];
        }
        return response()->json($return);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $res = Category::find($id);
        if ($res) {
            $res->delete();
            return response()->json(['status' => 'success', 'message' => 'Category is deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Category not deleted ']);
        }
    }
    public function getProductByCategory(Request $request)
    {
        $result = getProductByCategory($request->id);
        if ($request->ajax()) {
            if (!empty($request->catIds)) {
                $query  = Product::whereNull('products.deleted_at');
                $categoryproducts = $query->whereIn('products.category_id', $request->catIds)->get();
                //    print_r($categoryproducts);exit;
                if (!($categoryproducts->isEmpty())) {
                    $return = ['status' => 'success', 'categoryProducts' => $categoryproducts];
                    //   return response()->json($return);
                } else {
                    $return = ['status' => 'error', 'message' => 'No record found'];
                }
                // return response()->json($return);
            } else {
                $return = ['status' => 'error', 'message' => 'No record found'];
            }
            return response()->json($return);
        }

        $storeProductCategory = getCategory(true);
        // echo "<pre>";print_r($storeProductCategory);exit;
        $dt = ['products' => $result, 'storeProductCategory' => $storeProductCategory];
        return view('web.category_products.index', $dt);
    }


    public function getProductByCat(Request $request)
    {

        $colors = explode("&", $request->colorIds);
        $store = getCurrentStore('store');
        //$store = Store::where('slug', $request->slug)->where('deleted_at', '=', NULL)->first();
        $productColors = str_replace("colors%5B%5D=", " ", $colors);
        if (!empty($request->catId)) {
            $result = getProductByCategory(!empty($request->catId) ? $request->catId : -1, -1, -1, $store->id, !empty($productColors) ? $productColors : -1,$request->minimum_range,$request->maximum_range);
            $filterPrices  = getFilterPrices(!empty($request->catId) ? $request->catId : -1,$store->id,!empty($productColors) ? $productColors : -1);
            if (!($result->isEmpty())) {
                $dt = ['productsData' => $result, 'store' => $store];
                $html = view('stores.front.ajax.filter_products', $dt)->render();
                $response = [
                    'status' => 'success',
                    'filterPrices'=>$filterPrices,
                    'totalProducts'=>$result->count(),
                    'html' => $html
                ];
            } else {
                $response = [
                    'status' => 'error',
                ];
            }
        } else {
            if (!empty($store)) {
                $filterPrices  = getFilterPrices(!empty($request->catId) ? $request->catId : -1,$store->id);
                $storeSetting = StoreSetting::where('store_id', $store->id)->first();
                $storeProductCategory = getProductByCategory(-1, -1, -1, $store->id);
                $dt = [
                    'productsData' => $storeProductCategory,
                    'store' => $store,
                ];
                $html = view('stores.front.ajax.filter_products', $dt)->render();
                $response = [
                    'status' => 'success',
                    'filterPrices'=>$filterPrices,
                    'totalProducts'=>$storeProductCategory->count(),
                    'html' => $html
                ];
            } else {
                return redirect('/');
            }
        }
        return response()->json($response);
    }
}

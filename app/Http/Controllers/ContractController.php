<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\StoreProductPricingMapping;
use Illuminate\Support\Facades\DB;
use App\Models\Contract;
use App\Models\Product;
use App\Models\ProductContractMapping;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contracts.list');
    }

    public function create(){
        $category  = getCategory(true);
        $products  = Product::whereNull('deleted_at')->get();
        $dt = ['category'=>$category];
        return view('contracts.create',$dt);
    }

    public function getList(Request $request) {
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $userId = auth()->user()->id;
        $contract = DB::table('contracts');
        $contract->where('deleted_at', NULL);
        $contract->where('is_active','=','1');;
        foreach($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if($search != "") {
                if ($col == 'Name') {
                    $col1='name';
                    $contract->where($col1, 'like','%' . $search . '%');
                }
                if ($col == 'Name') {
                    $col1='name';
                    $contract->where($col1, 'like','%' . $search . '%');
                }

            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $contract->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $contract->orderBy("name", "desc");
        }
        $iTotalRecords = $contract->count();
        $contract->skip($start);
        $contract->take($length);
        $contractData = $contract->get();
        $data = [];
        $i=1;
        foreach ($contractData as $contractObj) {
            $action = "";

                $action .= '<a href="' . route('getContractById', ['id' => $contractObj->id]) . '" class="btn btn-sm btn-clean btn-icon edit" data-id="' . $contractObj->id . '" title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';


                $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $contractObj->id . '" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';

            $data[] = [
                "id" => $i,
                "Name" => $contractObj->name,
                "Amount" => $contractObj->amount,
                "Duration" => Carbon::create($contractObj->start_date)->format(config('app.date_time_format', 'M j, Y')).' '.Carbon::create($contractObj->end_date)->format(config('app.date_time_format', 'M j, Y')),
                "created_at" => Carbon::create($contractObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//         print_r($request->all());exit;
        $id = $request->id;
        $contract = new Contract();
        if($id > 0) {
            $contract = Contract::findOrFail($id);
        }
        $dateRange  = explode("-",$request->date_range);
        $startDate = $dateRange[0];
        $endDate = $dateRange[1];
        $isActive = 1;
       /* if(isset($request->is_active) && $request->is_active == "on") {
            $isActive = 1;
        }*/
        // print_r($dateRange);exit;
        $contract->name = $request->name;
        $contract->amount = $request->percentage;
        $contract->contract_type = $request->contract_type;
        $contract->start_date = Carbon::parse($startDate)->format('Y-m-d');
        $contract->end_date = Carbon::parse($endDate)->format('Y-m-d');
        $contract->added_by = Auth::user()->id;
        $contract->note = $request->notes;
        $contract->is_active = $isActive;
        $query = $contract->save();
        $contractType = $request->contract_type;
        $productIds = $request->product_id;
        $contractPrice = $request->contract_price;
        ProductContractMapping::where('contract_id',$id)->delete();
         if(!empty($productIds)){
             $productData = [];
             foreach($productIds as $k => $productObj){
                //  if(!empty($contractPrice[$k])){
                     $productData[] = [
                         'contract_id'=>$contract->id,
                         'product_id'=>$productObj,
                         'discount'=> ($contractType == 'all') ? $contractPrice[0] : $contractPrice[$k],
                         'type'=> 'percentage',
                     ];
                //  }
             }
            }
            if(!empty($productData)){
                ProductContractMapping::insert($productData);
            }

            /*$stores=getContractStores(false,$contract->id);
            if(!empty($stores)){

                //echo "nooooo yr";exit;
            }*/

            //  print_r($productData);exit;
        $return = [
            'status' => 'error',
            'message' => 'Contract is not save successfully',
        ];
        if($query) {
            $return = [
                'status' => 'success',
                'message' => 'Contract is save successfully',
            ];
        }
        return response()->json($return);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $res = Contract::find($id);
        $contractSetting = ProductContractMapping::where('contract_id',$id);
        if ($res) {
            $res->delete();
            $contractSetting->delete();
            return response()->json(['status' => 'success','message' => 'Contract is deleted successfully']);
        } else {
            return response()->json(['status' => 'error','message' => 'Contract not deleted beacuse it is assigned']);
        }
    }

    public function getContractById(Request $request) {
        $id = $request->id;
        $contract = Contract::with('contractMappings')->where('id', $id)->first();
        $productIds = ProductContractMapping::leftJoin('products as p','product_contract_mappings.product_id','p.id')->where('contract_id',$contract->id)->pluck('product_id')->toArray();
        $categoryIds = Product::whereIn('id', $productIds)->pluck('category_id')->toArray();
        $selectedProducts  = Product::leftJoin('product_contract_mappings as scm' ,'products.id','scm.product_id')->select('products.name','products.id','scm.discount','scm.type')->whereIn('products.id',$productIds)->where('scm.contract_id',$id)->whereIn('products.category_id', $categoryIds)->whereNull('scm.deleted_at')->get();
        $category  = getCategory(true);
        $products  = Product::whereNull('deleted_at')->get();
        $dt = ['category'=>$category,'products'=>$products,'contract'=>$contract,'productIds'=>$productIds,'categoryIds'=>$categoryIds,'selectedProducts'=>$selectedProducts];
        return view('contracts.edit',$dt);
    }

    public function updateContract(Request $request)
    {
        $id = $request->id;
        $contract = new Contract();
        if($id > 0) {
            $contract = Contract::findOrFail($id);
        }
        $dateRange  = explode("-",$request->date_range);
        $startDate = $dateRange[0];
        $endDate = $dateRange[1];
        $isActive = 0;
        if(isset($request->is_active) && $request->is_active == "on") {
            $isActive = 1;
        }
        // print_r($dateRange);exit;
        $contract->name = $request->name;
        $contract->amount = $request->percentage;
        $contract->contract_type = $request->contract_type;
        $contract->start_date = Carbon::parse($startDate)->format('Y-m-d');
        $contract->end_date = Carbon::parse($endDate)->format('Y-m-d');
        $contract->added_by = Auth::user()->id;
        $contract->note = $request->notes;
        $contract->is_active = $isActive;
        $query = $contract->save();
        $return = [
            'status' => 'error',
            'message' => 'Contract is not update successfully',
        ];
        if($query) {
            $return = [
                'status' => 'success',
                'message' => 'Contract is update successfully',
            ];
        }
        return response()->json($return);
    }

    public function getProductAssignedList(Request $request,$contract_id)
    {
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnName='products.name';
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;

        $userId = auth()->user()->id;
        $contract = DB::table('products');
        //$contract->join('products','product_contract_mappings.product_id','=','products.id','left');
        $contract->join('categories','products.category_id','=','categories.id');
        $contract->leftJoin('product_contract_mappings', function($join) use ($contract_id){
            $join->on('product_contract_mappings.product_id','=','products.id');
            $join->on('product_contract_mappings.contract_id','=', DB::raw($contract_id));
            $join->where('product_contract_mappings.deleted_at', NULL);


        });
        $contract->select('products.name','products.id','categories.name as CategoryName','product_contract_mappings.id as mappingID','product_contract_mappings.discount','product_contract_mappings.type');
        $contract->where('products.deleted_at', NULL);

       // $contract->where('product_contract_mappings.contract_id', $contract_id);
        $contract->groupBy('products.id');
        foreach($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if($search != "") {

                if ($col == 'Name') {
                    $col1='products.name';
                    $col2='categories.name';
                    $contract->where($col1, 'like','%' . $search . '%');
                    $contract->orWhere($col2, 'like','%' . $search . '%');
                }

            }
        }
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $contract->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $contract->orderBy($sortColumnName, "desc");
        }

        $iTotalRecords = $contract->count();
        $contract->skip($start);
        $contract->take($length);
        $contractData = $contract->get();
        $data = [];
        $i=1;
        foreach ($contractData as $contractObj) {

            $ckdiscount=$contractObj->discount;
            isset($ckdiscount) && !empty($ckdiscount) ? $ckdiscount=$ckdiscount:$ckdiscount=NULL;
            $action = "";

            $discount='<input type="number" name="contract_price['.$contractObj->mappingID.']" id="contract_price_'.$contractObj->id.'" class="form-control mt-3 contract_price" placeholder="Enter Value" value="'.$ckdiscount.'" required><span id="contract_price_error_'.$contractObj->id.'" class="text-danger"></span>';
            $action .= '<button class="btn btn-primary save" data-id="' .$contractObj->id.'~'.$contractObj->mappingID . '">Save</button>';

            if($contractObj->discount!=''){
                $action .= '<button class="btn btn-primary delete float-right" data-id="' .$contractObj->id.'~'.$contractObj->mappingID . '">X</button>';
            }


            $data[] = [
                "Sr" => $i,
                "Name" => $contractObj->name,
                "Category" => $contractObj->CategoryName,
                "Discount" => $discount,
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
    public function contractRemove(Request $request)
    {
        $ids = explode('~',$request->id);
        $mappingID=$ids[1];
        $res = ProductContractMapping::find($mappingID);
        if ($res) {
            $res->delete();
            $productID=$res->product_id;
            $contractID=$res->contract_id;
            $storeIDs=getContractStores(false,$res->contract_id);
            if(!empty($storeIDs)){
                StoreProductPricingMapping::whereIN('store_id',$storeIDs)
                    ->where('product_id', $res->product_id)
                    ->update(['deleted_at' =>Carbon::now()->format('Y-m-d H:i:s')]);
            }

            return response()->json(['status' => 'success','message' => 'Product remove from contract successfully']);
        } else {
            return response()->json(['status' => 'error','message' => 'Product not removes from contract ']);
        }
    }
    public function contractSaved(Request $request)
    {


       $mappingID=$request->mapping_id;
       if($mappingID!=''){
           $contract = ProductContractMapping::findOrFail($mappingID);
       }
       else{
        $contract = new ProductContractMapping();
       }

       $contract->discount=$request->discount;
       $contract->product_id=$request->product_id;
       $contract->contract_id=$request->contract_id;

        $query = $contract->save();
        $return = [
            'status' => 'error',
            'message' => 'Contract product amount not update successfully',
        ];
        if($query) {

            if($mappingID=='')
            {

                $storePricing=array();
                $storeIDs=getContractStores(false,$request->contract_id);
                $contractProduct=getStoreContractProducts($productObj=false,$request->contract_id,$request->product_id);
                $overAllPrice = overallProductPrice($contractProduct->min_product_price, -1, $contractProduct->contract_discount);
                foreach($storeIDs as $storeID)
                {
                    $storePricing[]=array(
                        'store_id'=>$storeID,
                        'product_id'=>$request->product_id,
                        'sale_price' => $overAllPrice,
                        'created_at'=>Carbon::now()->format('Y-m-d H:i:s'),

                    );

                }
                //echo "<pre>";print_r( $storePricing);exit;
                $assignProducts = StoreProductPricingMapping::insert($storePricing);
             }
            $return = [
                'status' => 'success',
                'message' => 'Contract product amount update successfully',
            ];
        }
        return response()->json($return);
    }




}

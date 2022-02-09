<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class CustomerController extends Controller
{
    public function index() {

        $stores = getUserStore(true);
        $dt = [

            'stores' => $stores
        ];
        return view('customer.list', $dt);
    }

    public function getList(Request $request) {
        $type = auth()->user()->type;
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;

        $userStores=getUserStore();
        $user=User::select('users.*','stores.name as store_name')->whereNULL('users.deleted_at')->where('type','=','customer');
        $user->join('user_store_mappings','users.id','=','user_store_mappings.user_id');
        $user->join('stores','stores.id','=','user_store_mappings.store_id');
        $user->whereIn('user_store_mappings.store_id', $userStores);
        $user->whereNULL('users.deleted_at');
        $user->where('users.is_active','=','1');
        $user->where('users.id','!=',Auth::user()->id);

        foreach($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if($search != "") {

                if ($col == 'id') {
                    $user->where('stores.'.$col, $search);
                }
                if ($col == 'email') {
                    $user->where('users.'.$col,  'like','%' . $search . '%');
                }
                if ($col == 'name') {
                    $user->where('users.'.$col, 'like','%' . $search . '%');
                }

                if ($col == 'Phone Number') {
                    $colp='phone_number';
                    $user->where('users.'.$colp, 'like','%' . $search . '%');
                }

            }
        }
        $iTotalRecords = $user->count();
        $user->skip($start);
        $user->take($length);
        $userData = $user->get();
        $data = [];
        $i =1;
        foreach ($userData as $userObj) {
       
            if ($userObj->country_short_code){
                $phone = str_replace(array( '(', ' ', ')' ), '', $userObj->phone_number);

                $phoneNumber =$userObj->country_short_code.''.$phone;
            }else{
                $phone = str_replace(array( '(', ' ', ')' ), '', $userObj->phone_number);
                $phoneNumber = $phone;
            }
            $action = "";
            $action .= '<a href="' . route('customerOrders', ['id' => $userObj->id]) . '" target="_blank" title="Order details" class="btn btn-sm btn-clean btn-icon"><i class="la la-eye"></i></a>';
            /*$action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="'.$userObj->id.'" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';*/
            $data[] = [
                "id" => $i,
                "Store Name" => $userObj->store_name,
                "email" => $userObj->email,
                "name" => $userObj->name,
                "Phone Number" => $phoneNumber,
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

    public function nonRegisterCustomer(){


        $stores = getUserStore(true);
        $dt = [

            'stores' => $stores
        ];
        return view('customer.non_register_list', $dt);


    }

    public function nonCustomer(Request $request) {
        $type = auth()->user()->type;
        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;

        $userStores=getUserStore();
        $user=Order::select('orders.*','stores.name as store_name')->whereNULL('orders.deleted_at');
        $user->join('stores','stores.id','=','orders.store_id');
        $user->whereIn('orders.store_id', $userStores);
        $user->whereNULL('orders.deleted_at');
        $user->whereNULL('orders.user_id');
        $user->where('orders.payment','verified');


        foreach($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if($search != "") {

                if ($col == 'id') {
                    $user->where('stores.'.$col, $search);
                }
                if ($col == 'email') {
                    $user->where('orders.'.$col,  'like','%' . $search . '%');
                }
                if ($col == 'name') {
                    $user->where('orders.'.$col, 'like','%' . $search . '%');
                }

                if ($col == 'Phone Number') {
                    $colp='phone';
                    $user->where('orders.'.$colp, 'like','%' . $search . '%');
                }

            }
        }
        /*if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $user->orderBy("orders.email".$sortColumnName, $sortColumnSortOrder);
        } else {
            $user->orderBy("orders.id", "desc");
        }*/
        $user->groupBy('orders.email','orders.store_id');
        $iTotalRecords = $user->count();
        $user->skip($start);
        $user->take($length);
        $userData = $user->get();
        $data = [];
        $i =1;

        foreach ($userData as $userObj) {
            if ($userObj->country_short_code){
                $phone = str_replace(array( '(', ' ', ')' ), '', $userObj->phone);

                $phoneNumber =$userObj->country_short_code.''.$phone;
                }else{
                    $phone = str_replace(array( '(', ' ', ')' ), '', $userObj->phone);
                    $phoneNumber = $phone;
                }
            $action = "";

            $action .= '<a href="' . route('customerOrders', ['id' => $userObj->email]) .'" target="_blank" title="Order details" class="btn btn-sm btn-clean btn-icon"><i class="la la-eye"></i></a>';

            $data[] = [
                "id" => $i,
                "Store Name" => $userObj->store_name,
                "email" => $userObj->email,
                "name" => $userObj->name,
                "Phone Number" => $phoneNumber,
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

    public function customerOrders($email){

        $stores = getUserStore(true);
        $dt = [
                'stores' => $stores,
                'email_user' => $email,
        ];
        return view('customer.orders_list', $dt);


    }

    public function userOrdersList(Request $request){

        $records = [];
        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $sortColumnIndex = $request->order[0]['column']; // Column index
        $sortColumnName = $request->columns[$sortColumnIndex]['data']; // Column name
        $sortColumnSortOrder = $request->order[0]['dir']; // asc or desc
        $columns = $request->columns;
        $userType = auth()->user()->type;
        $userRoleIds = getRole();
        $stores = getUserStore();

        $sql = Order::select('*')->WhereIN('store_id', $stores)->where('payment','verified');
        if(is_numeric($request->user_email)){
            $sql->where('user_id',$request->user_email);
        }else{
            $sql->where('email',$request->user_email);
        }
        foreach ($columns as $field) {
            $col = $field['data'];
            $search = $field['search']['value'];
            if ($search != "") {
                if ($col == 'id') {
                    $col2 = 'status';
                    $sql->where($col, $search);
                    $sql->orwhere($col2, 'like', '%' . $search . '%');
                }
                if ($col == 'price') {
                    $col3 = 'store_id';
                    $sql->where($col3, $search);
                }
            }
        }
        $sql->whereNULL('deleted_at');
        if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $sql->orderBy($sortColumnName, $sortColumnSortOrder);
        } else {
            $sql->orderBy("id", "desc");
        }
        $iTotalRecords = $sql->count();
        $sql->skip($start);
        $sql->take($length);
        $orderData = $sql->get();
        $data = [];
        $statusoption = array('pending', 'approved', 'declined');
        foreach ($orderData as $orderObj) {
            $id = '<a href="' . route('detailProduct', ['id' => $orderObj->id]) . '" target="_blank" class="btn btn-solid btn-round btn-xs rounded-circle text-dark ">' . $orderObj->id . '</a>';
            $action = "";
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="' . $orderObj->id . '" title="Delete">
                    <i class="la la-trash"></i>
                </a>';

            $status = '<div class="form-group"><select class="form-control" onchange="updateStatus(' . $orderObj->id . ',this.value)" id="exampleFormControlSelect1">';
            $status .= '<option value="">Select Status</option>';
            foreach ($statusoption as $option) {
                $selected = '';
                if ($option == $orderObj->status) {
                    $selected = 'selected';
                }
                $status .= "<option value=" . $option . " $selected >$option</option >";
            }
            $status .= '</select></div>';

            $data[] = [
                "id" => $id,
                "price" => '£ ' . $orderObj->total_price,
                "created_at" => Carbon::create($orderObj->created_at)->format(config('app.date_time_format', 'M j, Y, g:i a')),
                "status" => $status,
                "action" => $action
            ];
        }
        $records["data"] = $data;
        $records["draw"] = $draw;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;
        echo json_encode($records);


    }






}

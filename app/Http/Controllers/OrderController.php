<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Store;
use App\Models\User;
use App\Models\StoreSetting;
use App\Models\Role;
use App\Models\UserStoreMapping;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\CustomerAccountDetail;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PAY360\Libraries\transactions;
use PAY360\Libraries\customers;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $stores = getUserStore(true);
        $dt = ['stores' => $stores];
        return view('orders.list', $dt);
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
        $userType = auth()->user()->type;
        $userRoleIds = getRole();
        $stores = getUserStore();



        $sql = Order::select('*')->WhereIN('store_id', $stores)->where('payment','verified');

        foreach ($columns as $field) {

            $col = $field['data'];
            $search = $field['search']['value'];


            if ($search != "") {
                if ($col == 'store_name') {
                    $col1 = 'store_id';
                    $sql->where($col1, $search);

                }
                if ($col == 'id') {
                    $sql->where($col, $search);

                }

                /*if ($col == 'price') {
                    $col5 = 'store_id';
                    $sql->where($col5, $search);
                }*/
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
            $storename = Store::where('id',$orderObj->store_id)->first();

            $data[] = [
                "id" => $id,
                "store_id" => $storename->name,
                "total_price" => '£ ' . $orderObj->total_price,
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


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrder(Request $request)
    {


       if (Auth::check()) {
            $userId = Auth::user()->id;
        }
        $validate = true;
        $validateInput = $request->all();
        if (!empty($userId)) {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'country' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip_code' => 'required',
                'country_short_code' => 'required',
                'selectedcontryname' => 'required',
            ];
        } else {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'country' => 'required',
                'city' => 'required',
                'state' => 'required',
                'zip_code' => 'required',
                'country_short_code' => 'required',
                'selectedcontryname' => 'required',
            ];
        }

        // Get the value from the form
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
        } else {

            $slug = getCurrentStore('slug');
            $storeDetail = getCurrentStore('store');

               // $storeDetail = Store::where('slug', $slug)->select('id')->first();

                if (Auth::check()) {
                    //$userId = Auth::user()->id;
                    $userDetail = User::where('id', Auth::user()->id)->first();
                    if($userDetail->phone_number == ""){
                        $UpdateDetails = User::where('id', Auth::user()->id)->update(array('phone_number' =>  $request->phone,'country_short_name' =>  $request->selectedcontryname,'country_short_code' =>  $request->country_short_code));
                       if($UpdateDetails){
                           $userDetail = User::where('id', Auth::user()->id)->first();
                       }else{
                           $userDetail = User::where('id', Auth::user()->id)->first();
                       }
                    }else{
                        $userDetail = User::where('id', Auth::user()->id)->first();
                    }
                }else{
                    $usercheck=User::selectRaw("users.*");
                    $usercheck->join('user_store_mappings','user_store_mappings.user_id','users.id');
                    $usercheck->where('user_store_mappings.store_id',$request->store_id);
                    $usercheck->where('users.email',$request->email);
                    $userDetail=$usercheck->first();

                    //$userDetail = User::where('email', $request->email)->select('email')->first();
                }

                $storeSetting = StoreSetting::where('store_id',$request->store_id)->first();

                $roleDetail = Role::where('name', 'customer')->select('id')->first();
                if ($request->create_account == 'on') {
                    if (empty($userDetail->email)) {
                        $password = $this->randomPassword();
                        $userNewDetail = new User;
                        $userNewDetail->name = $request->first_name . ' ' . $request->last_name;
                        $userNewDetail->role_id = $roleDetail->id;
                        $userNewDetail->email = $request->email;
                        $userNewDetail->u_name = preg_replace('/([^@]*).*/', '$1', $request->email). str_pad(mt_rand(1,999),4,'0',STR_PAD_LEFT);
                        $userNewDetail->phone_number = $request->phone;
                        $userNewDetail->country = $request->country;
                        $userNewDetail->state = $request->state;
                        $userNewDetail->city = $request->city;
                        $userNewDetail->address = $request->address;
                        $userNewDetail->country_short_name = $request->selectedcontryname;
                        $userNewDetail->country_short_code = $request->country_short_code;
                        $userNewDetail->email_verified_at = carbon::now()->format('Y-m-d H:i:s');
                        $userNewDetail->type = 'customer';
                        $userNewDetail->password = Hash::make($password);
                        $userNewDetail->save();

                        $storeMapping=new UserStoreMapping;
                        $storeMapping->user_id=$userNewDetail->id;
                        $storeMapping->store_id=$request->store_id;
                        $storeMapping->created_at=Carbon::now()->format('Y-m-d H:i:s');
                        $storeMapping->save();

                        $data['email'] = $request->email;
                        $data['from'] = isset($storeSetting->email) && !empty($storeSetting->email) ? $storeSetting->email:'';
                        $data['subject'] = 'Account Details';
                        $data['password'] = $password;
                        // Mail::to($data['email'])->send(new CustomerAccountDetail($data));
                    }
                }
                $usercheck=User::selectRaw("users.*");
                $usercheck->join('user_store_mappings','user_store_mappings.user_id','users.id');
                $usercheck->where('user_store_mappings.store_id',$request->store_id);
                $usercheck->where('users.email',$request->email);
                $userDetail=$usercheck->first();
                $cart = session()->get($slug);

                if (!empty($cart)) {
                    $storeId = $storeDetail->id;
                    $orderDetail = new Order;
                    $orderDetail->store_id = $storeId;
                    $orderDetail->user_id = !empty($userDetail->id) ? $userDetail->id : NULL;
                    $orderDetail->name = $request->first_name . ' ' . $request->last_name;
                    $orderDetail->email = $request->email;
                    $orderDetail->phone = $request->phone;
                    $orderDetail->address = $request->address;
                    $orderDetail->country = $request->country;
                    $orderDetail->total_price = $request->totle_paid_amount;
                    $orderDetail->paid_amount = $request->totle_paid_amount;
                    $orderDetail->paid_percentage = '100';
                    $orderDetail->city = $request->city;
                    $orderDetail->country_short_name = $request->selectedcontryname;
                    $orderDetail->country_short_code = $request->country_short_code;
                    $orderDetail->state = $request->state;
                    $orderDetail->zip_code = $request->zip_code;
                    $orderDetail->card_owner_name = $request->user_card_name;
                    $orderDetail->card_owner_name = $request->user_card_no;
                    $orderDetail->card_exp_year = $request->exp_year;
                    $orderDetail->card_exp_month = $request->exp_month;


                    $orderQuery = $orderDetail->save();
                    if ($orderDetail->id > 0) {
                        $orderArr = [];
                        foreach ($cart as $productId => $arr) {
                            $k = array_key_first($arr);
                            if (!empty($k)) {
                                foreach ($arr as $dim => $ca) {
                                    $orderArr[] = [
                                        'order_id' => $orderDetail->id,
                                        'product_id' => $productId,
                                        'dimension' => $dim,
                                        'fitting_type' => $ca['fitting'],
                                        'fitting_option' => $ca['set_fitting'],
                                        'side_control' => $ca['side_control'],
                                        'chain_color' => $ca['chain_color'],
                                        'qty' => $ca['quantity'],
                                        'scale' => $ca['scale'],
                                        'price' => $ca['price'],
                                    ];
                                }
                            }
                        }

                        $query = OrderItem::insert($orderArr);

                        if ($query) {
                            if (isset($storeSetting->email)){
                                $orderId = carbon::now()->format('m');
                                $order_id = $orderId . str_pad($orderDetail->id, 1, 0, STR_PAD_LEFT);
                                $data['email'] = $request->email;
                                $data['from'] =isset($storeSetting->email) && !empty($storeSetting->email) ? $storeSetting->email:'';
                                $data['subject'] = 'Order Confirmation';
                                $data['orderId'] = $order_id;
                                // Mail::to($data['email'])->send(new OrderConfirmation($data));
                                Session()->forget($slug);
                            }else{
                                $orderId = carbon::now()->format('m');
                                $order_id = $orderId . str_pad($orderDetail->id, 1, 0, STR_PAD_LEFT);
                                $data['email'] = $request->email;
                                $data['from'] = isset($storeSetting->email) && !empty($storeSetting->email) ? $storeSetting->email:'';
                                $data['subject'] = 'Order Confirmation';
                                $data['orderId'] = $order_id;
                                // Mail::to($data['email'])->send(new OrderConfirmation($data));
                                Session()->forget($slug);
                            }
                            $instid = 5309321; // Hosted Cashier Installation ID
                            $u = "HE336BPMNFBFFEU34AUEPUP4EI"; // API Username
                            $p = "U+UBm3pJ/gtb3FSGoTOh8w=="; // API Password
                            $host = "https://api.mite.pay360.com"; // Test
                            //$host = "https://api.pay360.com"; // Live

                            $currentURL = \URL::to('/');

                            $post = array(
                                "session" => array(
                                    //"returnUrl" => array("url" => "http://localhost/ecomcustom/public/store/test-store-contract?response_id=$orderDetail->id"),
                                    "returnUrl" => array("url" => $currentURL."?response_id=$orderDetail->id"),
                                    "transactionNotification" => array("url" => "http://localhost/ecomcustom/public/test/callback.html",
                                        "format" => "REST_JSON")
                                ),

                                "transaction" => array("merchantReference" => "$instid",
                                    "money" => array("amount" => array("fixed" => $request->totle_paid_amount),
                                        "currency" => "GBP"
                                    )
                                ),

                                "customer" => array("registered" => false,
                                    "details" => array(
                                        "name" => $request->first_name.' '.$request->last_name,
                                        "address" => array("line1" => $request->address,
                                        "line2" => $request->address,
                                        "city" => $request->city,
                                        "region" => $request->state,
                                        "postcode" => $request->zip_code,
                                        "countryCode" =>"PAK"),
                                        "telephone" => $request->phone,
                                        "emailAddress" => $request->email,
                                        "ipAddress" => $_SERVER['REMOTE_ADDR'],
                                        "defaultCurrency" => "GBP"
                                    )
                                )
                            );

                            $ch = curl_init("$host/hosted/rest/sessions/$instid/payments");

                            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

                            curl_setopt($ch, CURLOPT_USERPWD, "$u:$p");
                            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                            $response = curl_exec($ch);
                            curl_close($ch);
                            $getredirectUrl=json_decode($response);

                            return redirect($getredirectUrl->redirectUrl);
                            //$return = ['status' => 'success', 'message' => 'Your order submitted successfully!'];
                        } else {
                            $return = ['status' => 'error', 'message' => 'Sorry Your order not submitted!'];
                        }
                    }
                }
            }
            return response()->json($return);
        }



        public function randomPassword()
        {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }

    /**
         * Display the specified resource.
         *
         * @param \App\Models\Order $order
         * @return \Illuminate\Http\Response
         */
        public function show(Order $order)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param \App\Models\Order $order
         * @return \Illuminate\Http\Response
         */
        public function edit(Order $order)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param \App\Models\Order $order
         * @return \Illuminate\Http\Response
         */
        public  function update(Request $request, Order $order)
        {
            //
        }

        public function destroy(Request $request)
        {
            $id = $request->id;
            $res = Order::find($id);
            $item = OrderItem::where('order_id', $id);
            if ($res && $item) {
                $res->delete();
                $item->update(['deleted_at' => Carbon::now()->format('Y-m-d H:i:s')]);
                return response()->json(['status' => 'success', 'message' => 'Order is deleted successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Order not deleted ']);
            }
        }

        public function orderUpdate(Request $request)
        {
            $id = $request->id;
            $res = Order::find($id);
            if ($res) {
                $res->update(['status' => $request->status]);
                return response()->json(['status' => 'success', 'message' => 'Order is updated successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Order not updated ']);
            }
        }

        public function filterStatus(Request $request)
        {
            $user= Order::with(['orderdetail'=>function($query){
                $query->with('orderProducts');
            }])->where('user_id',Auth::user()->id);
            if($request->order_status!='all'){
                $user->where('status','=',$request->order_status);
            }
            $userOrder=$user->orderBy('id', 'DESC')->get();
            $dt = [
                'userOrder' => $userOrder
            ];
            $html = view('users.ajax.user_order_filter', $dt)->render();
            $return = [
                'html' => $html,

            ];
            return $return;
        }
        public function verifyPayment(Request $request){

            $id = $request->order_id;
            //$res = Order::where('id',$id)->where();
            $res=Order::where('payment','unverified')
                ->where('id', $id)
                ->update(['payment' => 'verified']);
            if ($res) {
               return response()->json(['status' => 'success', 'message' => 'Order is submitted successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Order not updated ']);
            }


        }




    }


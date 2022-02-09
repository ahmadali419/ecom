<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Store;
use App\Models\StoreSetting;
use App\Models\UserStoreMapping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
class UserController extends Controller
{
    public function index() {

        $roles = getRole(true);
        $types = [
            'employee' => 'Employee',
            'shop' => 'Shop'
        ];
        $stores = getUserStore(true);
        $dt = [
            'types' => $types,
            'roles' => $roles,
            'stores' => $stores
        ];
        return view('users.list', $dt);
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
        $user=User::select('users.*','stores.name as store_name')->whereNULL('users.deleted_at')->where('type','!=','customer');
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
                    $phone = substr($search, -4);
                   $user->where('users.'.$colp, 'like','%' . $phone . '%');

                }

            }

        }

        /*if ((isset($sortColumnName) && !empty($sortColumnName)) && (isset($sortColumnSortOrder) && !empty($sortColumnSortOrder))) {
            $user->orderBy("u.".$sortColumnName, $sortColumnSortOrder);
        } else {
            $user->orderBy("u.id", "desc");
        }*/

        //$user->groupBy('users.id');
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
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon edit" data-id="'.$userObj->id.'" title="Edit details">
                            <i class="la la-edit"></i>
                        </a>';
            $action .= '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete" data-id="'.$userObj->id.'" title="Delete">
                            <i class="la la-trash"></i>
                        </a>';
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

    public function store(Request $request) {

        $validate = true;
        $id = $request->id;
        $username = $request->u_name;
        $email = $request->email;
        $phoneNumber = $request->phone_number;
        $user = new User();
        // Get the value from the form
        $validateInput = $request->all();
        $rules = [
            'email' => 'required',
            'u_name' => 'required',
            'phone_number' => 'required',
            'name' => 'required',
            'role_id' => 'required',
            'store' => 'required',
            'selectedcontryname' => 'required',
            'selectcuntrycode' => 'required',

        ];
        if ($id > 0) {
           $user = User::findOrFail($id);
            if($username != $user->u_name) {
                $rules['u_name'] = 'required|unique:users,u_name';
            }
            if($phoneNumber != $user->phone_number) {
                $rules['phone_number'] = 'required|unique:users,phone_number';
            }
        }
        else{

            $rules['u_name'] = 'required|unique:users,u_name';
            $rules['phone_number'] = 'required|unique:users,phone_number';
            $rules['password'] = 'required|min:5';
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
        }
        if($validate) {
            $isActive = 0;
            if(isset($request->is_active) && $request->is_active == "on") {
                $isActive = 1;
            }

            $password = $request->password;
            $user->email = $request->email;
            $user->u_name = $username;
            $user->phone_number = $phoneNumber;
            $user->cnic = $request->cnic;
            $user->name = $request->name;
            $user->country_short_name = $request->selectedcontryname;
            $user->country_short_code = $request->selectcuntrycode;
           // $user->is_admin = 1;
            $user->added_by = Auth::user()->id;
            if($id=='' && $request->password != "") {
                $user->password = Hash::make($password);
            }
            $user->role_id = $request->role_id;
            $user->type = $request->type;
            if($id == "") {
                $user->email_verified_at = Carbon::now()->format("Y-m-d H:i:s");
            }
            //$user->is_active = $isActive;
            if ($request->file('profile')) {
                $destinationPath = public_path('user/profile/'); // upload path
                File::isDirectory($destinationPath) or File::makeDirectory($destinationPath, 0775, true, true);
                $fileName = uniqid() . '.' .$request->file('profile')->getClientOriginalExtension(); // getting file extension
                if(\File::exists(public_path('user/profile/'.$request->old_image))){
                    \File::delete(public_path('user/profile/'.$request->old_image));
                }
                $upload_success = $request->file('profile')->move($destinationPath, $fileName);
                if($upload_success) {
                    $user->photo =  $fileName;
                }
            }
            $query = $user->save();
            $return = [
                'status' => 'error',
                'message' => 'Data is not save successfully',
            ];
            if ($query) {
                $userID=$user->id;
                DB::table('user_store_mappings')->where('user_id', $userID)->delete();
                $stores=$request->input('store');
                $storemapping=array();
                foreach($stores as $store)
                {
                    $storemapping[]=array(
                        'user_id'=>$userID,
                        'store_id'=>$store,
                        'created_at'=>Carbon::now()->format("Y-m-d H:i:s")
                    );
                }
                DB::table('user_store_mappings')->insert($storemapping);
                $return = [
                    'status' => 'success',
                    'message' => 'User is save successfully',
                ];
            }
        }
        return response()->json($return);
    }

    public function getUserById(Request $request) {
        $id = $request->id;
        $user = User::where('id', $id)->first();
        $stores=UserStoreMapping::where('user_id',$user->id)->select('store_id')->get();
        $storeIDs=array();
        foreach ($stores as $store)
        {
            $storeIDs[]=$store->store_id;
        }

        $storeIDs=implode(',', $storeIDs);
        $return = [
            'status' => 'success',
            'data' => $user,
            'stores' => $storeIDs,
            'imagePath' => asset('user/profile').'/'.$user->photo,
        ];
        if(empty($user)) {
            $return = [
                'status' => 'error',
                'message' => 'Data not found for edit'
            ];
        }
        return response()->json($return);
    }

    public function destroy(Request $request) {
        $id = $request->id;
        $branch = User::findOrFail($id);
        $branch->is_active = 0;
        $branch->save();
        return response()->json(['status' => 'success','message' => 'User is deleted successfully']);
    }

    public function userProfile(){

        $store = getCurrentStore('store');
        //$store = Store::where('slug', $slug)->whereNULL('deleted_at')->first();
        $storeSetting = StoreSetting::where('store_id', $store->id)->first();
        $storeProductCategory = getCategory(true, $categoryId = "", $type = "product", $store->id);
        $storeProductColor = getColore(true, $colorId = '', $store->id);
        $storeProductTag = gettags(true, $tagId = '', $store->id);
        $userOrder='';
        if(Auth::check())
        {
            //$userOrder=Order::where('user_id',Auth::user()->id)->where('store_id',$store->id)->get();
            $userOrder= Order::with(['orderdetail'=>function($query){
                $query->with('orderProducts');
            }])->where('user_id',Auth::user()->id)->orderBy('id', 'DESC')->get();
         }


        $dt = ['store' => $store, 'storeSetting' => $storeSetting, 'storeProductCategory' => $storeProductCategory, 'storeProductColor' => $storeProductColor, 'storeProductTag' => $storeProductTag,'userOrder'=>$userOrder];

        return view('users.user_account', $dt);

    }

    public function updateProfile(Request $request)
    {
        $validate = true;
        $validateInput = $request->all();

        $rules = [

            'name' => 'required',
            'u_name' => 'required|max:100',
            'phone' => 'required|max:100',
            'selectedcontryname' => 'required',
            'selectcuntrycode' => 'required',

        ];
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
        }
        if ($validate) {

            $id=Auth::user()->id;
            $userObj = User::find($id);
            if ($request->hasFile('user_image')) {
                $userAttach = $request->file('user_image');
                $userAttach = uniqid() . '.' . $request->user_image->getClientOriginalExtension();
                $request->user_image->move(public_path('user/profile/'), $userAttach);
                $userObj->photo = $userAttach;
                if(\File::exists(public_path('user/profile/'.$request->old_image))){
                    \File::delete(public_path('user/profile/'.$request->old_image));
                }
            }
            $userObj->name=$request->name;
            //$userObj->u_name=$request->u_name;
            $userObj->phone_number=$request->phone;
            $userObj->country_short_name=$request->selectedcontryname;
            $userObj->country_short_code=$request->selectcuntrycode;
            $userObj->address=$request->address;
            $userObj->country=$request->country;
            $userObj->city=$request->city;
            $userObj->state=$request->state;
            $userObj->zip_code=$request->zip_code;

            if(!$userObj->save())
            {
                $return = [
                    'status' => 'error',
                    'message' => 'User information is not saved ',
                ];
            }
            else
            {
                $return = [
                    'status' => 'success',
                    'message' => 'User information is save successfully',
                ];
            }
        }
        return response()->json($return);
    }

    public function EdituserProfile() {
        $id = auth::user()->id;
        $user = User::where('id', $id)->first();
        return view('users.profile_edit');
    }
    public function PasswordUpdate(Request $request){

        $validate = true;
        $validateInput = $request->all();

        $rules = [

            'currentpassword' => 'required',
            'newpassword' => 'min:8|required_with:password_confirmation|same:cpassword',
            'cpassword' => 'min:8'
        ];
       $message =  [];
        $validator = Validator::make($validateInput, $rules, $message,[
            'newpassword' => 'New Password',
            'cpassword' => 'Confirm Password',
        ]);
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
            $id = auth::user()->id;
            $userObj = User::find($id);
            $user = User::where('id', $id)->first();
            $newpassword = Hash::make($request->newpassword);
            $validatePassword = Hash::check($request->currentpassword, $user->password);

            if ($validatePassword > 0) {
                $userObj->password=$newpassword;
                if(!$userObj->save())
                {
                    $return = [
                        'status' => 'error',
                        'message' => 'Your information is not saved.',
                    ];
                }
                else
                {
                    $return = [
                        'status' => 'success',
                        'message' => 'Your information is save successfully.',
                    ];
                }

            } else {
                $return = [
                    'status' => 'error',
                    'message' => 'Your current Password is Not Match.',
                ];

            }
        }
        return response()->json($return);
    }

}

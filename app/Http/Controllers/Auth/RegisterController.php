<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Store;
use App\Models\UserStoreMapping;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use http\Client\Response;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $return = [];
        $rules = [
            'name' => 'required|string|max:255',
            'u_name' => 'required|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $allMsg = [];
            foreach ($errors->all() as $message) {
                $allMsg[] = $message;
            }
            $return['status'] = 'error';
            $return['message'] = collect($allMsg)->implode('<br />');
        }
        return $return;
    }

    public function register(Request $request)
    {

        $return = $this->validator($request->all());

        if(isset($return['status']) && $return['status'] == 'error') {
            if($request->ajax()) {
                return new JsonResponse($return, 201);
            }
        }
        event(new Registered($user = $this->create($request)));

        Auth::loginUsingId($user['user_id']);

        if($request->ajax()) {
            return new JsonResponse($user, 201);
        } else {
            return $request->wantsJson()
                ? new JsonResponse([], 201)
                : redirect($this->redirectPath());
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create($request)
    {

        $data = $request->all();
        $role = Role::where('store_id',$data['store_id'])->where('name','customer')->first();
        $store = Store::where('id', $data['store_id'])->whereNULL('deleted_at')->first();
        $roleID=$role->id;
        $user = User::create([
            'name' => $data['name'],
            'u_name' => $data['u_name'],
            'email' => $data['email'],
            'role_id' => $roleID,
            'type' =>'customer',
            'password' => Hash::make($data['password']),
        ]);

        if($user) {
            UserStoreMapping::create([
                'user_id' => $user->id,
                'store_id' => $data['store_id'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')

            ]);

            $return = [
                'status' => "success",
                'user_id' => $user->id
            ];
        } else {
            $return = [
                'status' => "error",
                'message' =>"Something wrong please try again!"
            ];
        }
        return $return;
    }

    public function username()
    {
        return 'u_name';
    }

}

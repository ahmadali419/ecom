<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreSetting;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //    use AuthenticatesUsers;
    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $username;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username = 'u_name';
    }
    public function storeLogin()
    {
        $store = getCurrentStore('store');
        if (!empty($store)) {
            $store_id = $store->id;
            $storeSetting = getCurrentStore('store_setting');
            $storeProductCategory = getCategory(true, $categoryId = "", $type = "product", $store_id);
            $storeProductColor = getColore(true, $colorId = '', $store_id);
            $storeProductTag = gettags(true, $tagId = '', $store_id);
            $dt = [
                'store' => $store,
                'storeSetting' => $storeSetting,
                'storeProductCategory' => $storeProductCategory,
                'storeProductColor' => $storeProductColor,
                'storeProductTag' => $storeProductTag
            ];

            return view('customer.login', $dt);
        } else {
            return view('customer.emply_page');
        }
    }
    public function adminLogin() {
        return view('auth.login');
    }
    protected function credentials(Request $request)
    {
        $credentials = $request->only('u_name', 'password');
        $credentials['is_active'] = 1;
        return $credentials; /* ['email' => 'test@email.com', 'password' => 'scert', 'active' => 1] */
    }

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {

        if ($request->ajax()){
            return response()->json([
                'auth' => auth()->check(),
                'user' => $user,
                'intended' => $this->redirectPath(),

            ]);
        }
    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect('admin/login');
    }

    public function username()
    {
        return $this->username;
    }
}

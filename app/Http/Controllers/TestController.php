<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PAY360\Libraries\transactions;
use PAY360\Libraries\customers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class TestController extends Controller
{

    public function index() {
        $order = (object) [
            'id' => 123,
            'totalgross' => 5,
            'name' => "test",
            'addr1' => "fasial town",
            'addr2' => "",
            'city' => "Lahore",
            'county' => "Punjab",
            'country' => "PAK",
            'postcode' => 54000,
            'telephone' => "03006982454",
            'email' => "test@gmail.com"
        ];

        $post = array(
            "session" => array(
                "returnUrl" => array("url" => "http://localhost/ecomcustom/public/test/?id=$order->id"),
                "transactionNotification" => array("url" => "http://localhost/ecomcustom/public/test/callback.html",
                    "format" => "REST_JSON")
            ),

            "transaction" => array("merchantReference" => "$order->id",
                "money" => array("amount" => array("fixed" => $order->totalgross),
                    "currency" => "GBP"
                )
            ),

            "customer" => array("registered" => false,
                "details" => array(
                    "name" => $order->name,
                    "address" => array("line1" => $order->addr1,
                        "line2" => $order->addr2,
                        "city" => $order->city,
                        "region" => $order->county,
                        "postcode" => $order->postcode,
                        "countryCode" => $order->country),
                    "telephone" => $order->telephone,
                    "emailAddress" => $order->email,
                    "ipAddress" => $_SERVER['REMOTE_ADDR'],
                    "defaultCurrency" => "GBP"
                )
            )
        );

        $instid = 5309321; // Hosted Cashier Installation ID
        $u = "HE336BPMNFBFFEU34AUEPUP4EI"; // API Username
        $p = "U+UBm3pJ/gtb3FSGoTOh8w=="; // API Password
        $host = "https://api.mite.pay360.com"; // Test
        //$host = "https://api.pay360.com"; // Live

        $ch = curl_init("$host/hosted/rest/sessions/$instid/payments");

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

        curl_setopt($ch, CURLOPT_USERPWD, "$u:$p");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);


        $obj = json_decode($response);
        $data = json_decode(file_get_contents("php://input"));
        echo "<pre>";
        echo "obj";
        print_r($obj);
        echo "data";
        print_r($data);
        echo "</pre>";
        die;
        if($orderid = $data->transaction->merchantRef){
            $transactionStatus = $data->transaction->status;
            $total = $data->transaction->amount;

            if($transactionStatus == "SUCCESS"){
                // Transaction successful
            }
        }
        echo "<pre>";
        print_r($obj);
        echo "</pre>";
        die;

    }
    public function userprofile()
    {
        return view('users.profile_edit');
    }
    public function logout(){
        return redirect('admin/login');
    }
    use AuthenticatesUsers {
        logout as performLogout;
    }
    public function costomerlogout(Request $request)
    {

        $this->performLogout($request);
        $store = getCurrentStore('store_setting');
        return redirect($store->store_link);
    }
}

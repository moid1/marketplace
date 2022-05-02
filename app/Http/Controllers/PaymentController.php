<?php

namespace App\Http\Controllers;

use Botble\Payment\Models\Payment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    function changePaymentStatus(Request $request)
    {
        $error_msg = "Unknown error";
        $auth_ok = false;
        $request_data = null;


        if (isset($_SERVER['HTTP_X_NOWPAYMENTS_SIG']) && !empty($_SERVER['HTTP_X_NOWPAYMENTS_SIG'])) {
            $recived_hmac = $_SERVER['HTTP_X_NOWPAYMENTS_SIG'];

            $request_json = file_get_contents('php://input');
            $request_data = json_decode($request_json, true);
            ksort($request_data);
            $sorted_request_json = json_encode($request_data, JSON_UNESCAPED_SLASHES);

            if ($request_json !== false && !empty($request_json)) {
                $hmac = hash_hmac("sha512", $sorted_request_json, trim($this->ipn_secret));

                if ($hmac == $recived_hmac) {
                    $auth_ok = true;
                } else {
                    $error_msg = 'HMAC signature does not match';
                }
            } else {
                $error_msg = 'Error reading POST data';
            }
        } else {
            $error_msg = 'No HMAC signature sent.';
        }
        
        if($auth_ok){
              Payment::where('id', 64)
                    ->update(['status' => 'tesadsgag']);

        return response()->json(200);
        }else{
           Payment::where('id', 64)
                    ->update(['status' => 'failed']);
                            return response()->json(200);

        }
    }
}

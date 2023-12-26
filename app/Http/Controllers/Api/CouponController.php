<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\ServiceCopone;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CouponController extends Controller
{

    //user used his coupon

    public function used_coupon(Request $request){

        $service_id= $request->input('service_id');
        $user_id= $request->input('user_id');
        $coupon= Coupon::where([["code" , $request->code], ["service_id",$service_id],["enable", 1]])->first();
        
        $cheak = ServiceCopone::where('user_id',$user_id)->where('service_id',$service_id)->where('coupon',$coupon->id)->first();
        if($cheak != null){
            return response()->json([
                'status' => 401,
                'message' => "You can not use this coupon",
             ]);
        }else{
            $data =ServiceCopone::create([
                'user_id' =>$user_id,
                'service_id'=>$service_id,
                'coupon' => $coupon->id,
            ]);
            return response()->json([
                "status"=>200,
                "message"=>$data,
            ]);
        }


    }

    //check coupon validation
    public function check_coupon(Request $request){
        $service_id = $request->input('service_id');
        $code = $request->input('code');
        $coupon_id = Coupon::where([["code" , $code], ["service_id",$service_id],["enable", 1]])->pluck('id');
        $coupon    = Coupon::where([["code" , $code], ["service_id",$service_id],["enable", 1]])->get();

        if (count($coupon) >0) {
            return response()->json([
               'status' => 200,
               'message' => "You can use this coupon successfully","discount" =>$coupon,"CouponID"=>$coupon_id
            ]);
        }
        else{
            return response()->json([
                'status' => 401,
                'message' => "Not Found"
            ]);
        }

    }
}

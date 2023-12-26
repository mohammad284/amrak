<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use App\Models\ProviderReview;
use App\Models\ProviderWorkHour;
use App\Models\ServiceReview;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvidersController extends Controller
{
    //get provider state
    public function get_pro_details(Request $request){
        $id = $request->input('id');
        $data = User::where('id',$request->id)->get();

        $work_hour        = ProviderWorkHour::where('provider_id',$id)->with('providers','day')->get();
        $ratepro          = ProviderReview::where('provider_id',$id)->avg('rate');
        $count            = ProviderReview::where('provider_id',$id)->count();
        $accepted_booking = Booking::where('accept','1')->count();
        $final            = array('message'=>$data,'rate_for_provider'=>$ratepro,'count_rate'=>$count,'work_hour_for_provider'=>$work_hour,'accepted_booking'=>$accepted_booking);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                'details'=>$final
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }
    //add rate and review for a providers
    public function add_review_pro(Request $request){
        $provider_id = $request->input('provider_id');
        $customer_id = $request->input('customer_id');
        $rate = $request->input('rate');
        $comment = $request->input('comment');

        $date= ProviderReview::create([
            'provider_id' => $provider_id,
            'customer_id' => $customer_id,
            'comment' => $comment,
            'rate' => $rate
        ]);


        return response()->json([
            "status"=>200,
            "message"=>$date,
        ]);
    }
    public function get_review_pro(Request $request){
        $id = $request->input('id');
        $reviews = ProviderReview::where('provider_id',$id)->get();
        $review_details = [];
        foreach($reviews as $review){
            $customer = User::where('id',$review->customer_id)->first();
            $final = array('review'=>$review,'customer'=>$customer);
            array_push($review_details,$final);
        }
        if (count($review_details)>0){
            return response()->json([
                "status"=>200,
                "message"=>$review_details
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }

    }

}

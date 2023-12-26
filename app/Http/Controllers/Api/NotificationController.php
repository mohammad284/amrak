<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use App\Models\BookNotify;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kreait\Firebase\Messaging\CloudMessage;

class NotificationController extends Controller
{

    // get notification for user
    public function get_user_notify(Request $request){
        $id = $request->input('id');
        $data =BookNotify::where('user_id',$id)->where('unset',0)->paginate(8);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "message"=>$data,
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }
    //get notification for provider
    public function get_provider_notify(Request $request){
        $id = $request->input('id');
        $data =BookNotify::where('provider_id',$id)->where('unset',0)->with('customer','provider')->paginate(8);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "message"=>$data,
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }

    }
    //unset notification from user layout
    public function delete_notify(Request $request){
        $id = $request->input('id');

        $data = BookNotify::where('id',$id)->update([
            'unset'=>1
        ]);
//        return $data;

        if ($data){
            return response()->json([
                "status"=>200,
                "message"=>"delete successfully"
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }

    }

    public function edit_book_state(Request $request){
        $id = $request->input('id');
        $state =$request->input('state');

        $data = Booking::where('id',$id)->update([
            'booking_state_id'=>$state
        ]);
        $notify = ['title' => " إشعار خاص بالحجوزات ",
            'body' => 'تمت تعديل حالة الحجز.. ادخل و شاهد',
            'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            'type' => 1];
        $user = Booking::where('id',$id)->pluck('customer_id');
        $prov = Booking::where('id',$id)->pluck('provider_id');
        $serv = Booking::where('id',$id)->pluck('service_id');

        $messaging = app('firebase.messaging');
        $message1 = CloudMessage::fromArray([
            'topic' => "notify".$user,$prov,
            'notification' => $notify,
            'data' => ['تم تعديل حالة الحجز.. ادخل و شاهد', 'type' => 0,
                "created_at" => date("Y-m-d H:i:s"),'service'=>$serv], // optional
        ]);

        $messaging->send($message1);
         $noti_book = BookNotify::Create(['title' => $request->title],
            ['details' => $request->body],
            ['provider_id'=>$prov],
            ['user_id'=>$user],
            ['unset' => 0])->id;

        if($data){
            return response()->json([
                "status"=>201,
                "message"=>$data,"notify"=>$message1,"notify_book"=>$noti_book
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }
}


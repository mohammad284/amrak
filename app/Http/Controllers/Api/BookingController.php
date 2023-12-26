<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\PaymentMethod;
use App\Models\UserAddress;
use App\Models\BookingState;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // get payment method for users
    public  function get_payment_method(Request $request){
        $data = PaymentMethod::where('enable',1)->get()->paging(5);
        if (count($data)> 0){
            return response()->json([
                "status"=>200,
                "data"=>$data
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
                ]);
        }
    }
    public function get_address(Request $request){
        
        $id = $request->input('id');
        $data = UserAddress::where('user_id',$id)->get();
        if ($data != null){
            return response()->json([
                "status"=>200,
                "data"=>$data
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ]);
        }

    }

    // add user location
    public  function add_location(Request $request){
        $user_id = $request->input('user_id');
        $address = $request->input('address');
        $name = $request->input('name');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

        $data= UserAddress::create([
            'user_id' => $user_id,
            'address' => $address,
            'latitude' => $latitude,
            'name' => $name,
            'longitude' => $longitude,

        ]);


        return response()->json([
            "status"=>200,
            "message"=>$data,
        ]);
    }

    //adding booking /reservation
    public function add_booking(Request $request){

        $user_id = $request->input('user_id');
        $service_id = $request->input('service_id');
        $provider_id = $request->input('provider_id');
        $address = $request->input('address');
        $address_user = $request->input('address_user');
        $coupon_id = $request->input('coupon_id');
        $total = $request->input('total');
        $date = $request->input('date');
        $hint = $request->input('hint');
        $count = $request->input('count');

        $data= Booking::create([
            'customer_id' => $user_id,
            'service_id' => $service_id,
            'address' => $address,
            'provider_id' => $provider_id,
            'coupon_id' => $coupon_id,
            'book_date' => $date,
            'hint' => $hint,
            'count' => $count,
            'total' => $total,
            'lat'   => $request->lat,
            'lan'   => $request->lan,
        ]);
        // if (!empty($coupon_id))
        // {
        //     Coupon::find($coupon_id)->update([
        //         'user_id'=>$user_id,
        //         'is_used'=>1
        //     ]);

        // }
        $service_ord = Service::find($service_id);
        $service_ord->number_of_reserv += 1 ;
        $service_ord->save();
        return response()->json([
            "status"=>200,
            "message"=>$data,
        ]);
    }

    public function remove_booking(Request $request){
        $id =$request->input('id');
        $data = Booking::find($id)->delete();
        return response()->json([
            "status"=>200,
            "message"=>"delete successfully"
        ]);

    }


    public function get_user_booking(Request $request){
        $id =$request->input('id');
        $data = Booking::where('customer_id',$id)->orderBy('created_at','DESC')->with('customer','service','provider','booking_state')->paginate(4);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "data"=>$data
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ]);
        }
    }

    public function get_provider_booking(Request $request){
        $id =$request->input('id');
        $data = Booking::where('provider_id',$id)->with('customer','service','provider','booking_state')->paginate(4);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "data"=>$data
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ]);
        }
    }
    public function get_book_by_state(Request $request){
        $state= $request->input('state');
        $data = Booking::where('booking_state_id',$state)->where('customer_id',$request->user_id)->with('customer','service','provider','booking_state')->paginate(4);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "data"=>$data
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ]);
        }
    }
    public function changeStatus(){
        $booking = Booking::find($request->booking_id);
        $booking->booking_state_id = $request->state;
        $booking->save();
        return response()->json([
            "status"=>200,
            "data"=>$booking
        ]);
    }
    //get count of reservation of a service
    public function get_reserve_count(Request $request){
        $id = $request->input('id');
        $data = DB::select("select COUNT(id) AS numb FROM bookings where bookings.service_id =?",[$id]);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "data"=>$data
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ]);
        }
    }
    //get reservation state
    public function get_book_details(Request $request){
        $id = $request->input('id');
        $data = DB::select("SELECT bookings.id AS bookID, bookings.total,users.name ,
                booking_states.name AS book_state,services.name AS servNAme FROM bookings
                INNER JOIN booking_states ON bookings.booking_state_id=booking_states.id
                INNER JOIN users ON users.id=bookings.customer_id
                INNER JOIN services ON services.id=bookings.service_id
                WHERE bookings.id =? ",[$id]);

                    if (count($data)>0){
                        return response()->json([
                            "status"=>200,
                            "data"=>$data
                        ]);
                    }
                    else{
                        return response()->json([
                            "status"=>404,
                            "message"=>"Not Found"
                        ]);
                    }

    }
    //get customer booking
    public function get_user_booking_state(Request $request){
        $id = $request->input('id');
        $data = DB::select("SELECT bookings.total , booking_states.name as booking_state,
        users.name as customer FROM bookings INNER JOIN users ON users.id=bookings.customer_id
            INNER JOIN booking_states ON booking_states.id=bookings.booking_state_id
            WHERE bookings.customer_id =?",[$id]);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "data"=>$data
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ]);
        }

    }
    //get provider booking
    public function get_provider_booking_state(Request $request){
        $id = $request->input('id');
        $data = DB::select("SELECT bookings.total , booking_states.name as booking_state,
        users.name as provider FROM bookings INNER JOIN users ON users.id=bookings.provider_id
            INNER JOIN booking_states ON booking_states.id=bookings.booking_state_id
            WHERE bookings.provider_id =?",[$id]);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "data"=>$data
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ]);
        }
    }
    public function bookingStatus($lang){
        $status = BookingState::where('lang',$lang)->orderBy('created_at','DESC')->get();
        return response()->json([
            'status'  => '200',
            'details' => $status
        ]);
    }
}

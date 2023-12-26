<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingState;
use App\Models\BookNotify;
use App\Traits\Helper;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class BookingController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = Booking::with('payment_state', 'booking_state', 'provider', 'service', 'customer')->where('accept',0)->get();

            return Datatables::of($data)
                ->addIndexColumn()

                    ->addColumn('provider_id', function($row){
                        $lang = app()->getLocale();
                        if ($lang == 'ar'){
                            return $row->provider->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                        }elseif ($lang == 'en'){
                            return $row->provider->name ?? '<span class="badge bg-warning text-light">un defined</span>';
                        }

                    })->addColumn('customer_id', function($row) {
                    $lang = app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->customer->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->customer->name ?? '<span class="badge bg-warning text-light">un defined</span>';
                    }

                    })->addColumn('payment_state_id', function($row) {
                    $lang = app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->payment_state->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->payment_state->name ?? '<span class="badge bg-warning text-light">un defined</span>';
                    }

                    })->addColumn('booking_state_id', function($row) {

                    $lang = app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->booking_state->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->booking_state->name ?? '<span class="badge bg-warning text-light">un defined</span>';
                    }


                    })->addColumn('service_id', function($row) {
                    $lang = app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->service->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->service->name ?? '<span class="badge bg-warning text-light">un defined</span>';
                    }

                    })->addColumn('coupon_id', function($row) {
                    $lang = app()->getLocale();
                        if(empty($row->coupon_id)){
                            if ($lang == 'ar') {
                                return '<span class="badge bg-danger text-light">غير مستخدم</span>';
                            }elseif ($lang == 'en'){
                                return '<span class="badge bg-success text-light">not used</span>';

                            }
                        }else{
                            if ($lang == 'ar') {
                                return '<span class="badge bg-success text-light">مستخدم</span>';

                            }elseif ($lang == 'en'){
                                return '<span class="badge bg-success text-light">used</span>';

                            }
                        }

                    })->addColumn('action', function ($row) {

                        $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
//                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                        if($row->accept == 0){
                            $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Accept" class="btn btn-warning btn-sm accept" title="قبول"> <i class="fa fa-check-circle"></i> </a>';
                        }else if($row->accept == 1){
                            $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Reject" class="btn btn-success btn-sm reject" title="رفض"> <i class="fa fa-minus"></i> </a>';
                        }
                        return $btn;

                })
                ->rawColumns(['action','provider_id','customer_id','payment_state_id','booking_state_id','service_id','coupon_id'])
                ->make(true);

            return;
        }

        $lang = app()->getLocale();
        $states = BookingState::where('lang',$lang)->get(['id','name']);

        return view('admin.bookings.booking',compact('states'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
        $id = $request->_id;
        $validateErrors = Validator::make($request->all(),[

            'booking_state_id' => 'required',
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        }
        $data =[
            'booking_state_id' => $request->booking_state_id,
        ];

        Booking::where('id',$id)->update($data);



//          sending message.
        $notify = ['title' => " إشعار خاص بالحجوزات ", 'body' => 'تمت تعديل حالة الحجز.. ادخل و شاهد', 'click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'type' => 1];
        $user = Booking::where('id',$id)->get('customer_id');
        $prov = Booking::where('id',$id)->get('provider_id');
        $serv = Booking::where('id',$id)->get('service_id');

        $messaging = app('firebase.messaging');
        $message1 = CloudMessage::fromArray([
            'topic' => "notify".$user,$prov,
            'notification' => $notify,
            'data' => ['تم تعديل حالة الحجز.. ادخل و شاهد', 'type' => 0,
                "created_at" => date("Y-m-d H:i:s"),'service'=>$serv], // optional
        ]);

        $messaging->send($message1);
        BookNotify::Create(['title' => $request->title],
            ['details' => $request->body],
            ['provider_id'=>$prov],
            ['user_id'=>$user],
            ['unset' => 0]);

//        return response()->json(["status" => 200, "message" => " تمت العملية بنجاح .. تم إرسال إشعار"]);

        return response()->json(['status'=>200,'message' => 'تم الحفظ بنجاح' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
        return $this->editController(Booking::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(Booking::class,$id);
    }

    public function acceptableBooking(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = Booking::with('payment_state', 'booking_state', 'provider', 'service', 'customer')->where('accept',1)->get();

            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('provider_id', function($row){
                    $lang = app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->provider->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->provider->name ?? '<span class="badge bg-warning text-light">undefined</span>';
                    }

                })->addColumn('customer_id', function($row) {
                    $lang = app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->customer->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->customer->name ?? '<span class="badge bg-warning text-light">undefined</span>';
                    }

                })->addColumn('payment_state_id', function($row) {
                    $lang = app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->payment_state->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->payment_state->name ?? '<span class="badge bg-warning text-light">undefined</span>';
                    }

                })->addColumn('booking_state_id', function($row) {

                    $lang = app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->booking_state->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->booking_state->name ?? '<span class="badge bg-warning text-light">undefined</span>';
                    }


                })->addColumn('service_id', function($row) {
                    $lang = app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->service->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->service->name ?? '<span class="badge bg-warning text-light">undefined</span>';
                    }

                })->addColumn('coupon_id', function($row) {
                    $lang = app()->getLocale();
                    if (empty($row->coupon_id)) {
                        if ($lang == 'ar') {
                            return '<span class="badge bg-danger text-light">غير مستخدم</span>';
                        } elseif ($lang == 'en') {
                            return '<span class="badge bg-success text-light">not used</span>';

                        }
                    } else {
                        if ($lang == 'ar') {
                            return '<span class="badge bg-success text-light">مستخدم</span>';

                        } elseif ($lang == 'en') {
                            return '<span class="badge bg-success text-light">used</span>';

                        }
                    }
                })->addColumn('action', function ($row) {

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Reject" class="btn btn-success btn-sm reject" title="رفض"> <i class="fa fa-minus"></i> </a>';

                    return $btn;

                })
                ->rawColumns(['action','provider_id','customer_id','payment_state_id','booking_state_id','service_id','coupon_id'])
                ->make(true);

            return;
        }

        $lang = app()->getLocale();
        $states = BookingState::where('lang',$lang)->get(['id','name']);

        return view('admin.bookings.booking_accepted',compact('states'));
    }

    public function agree(Request $request, $id)
    {
        return $this->accept($request, $id, Booking::class);
    }
}

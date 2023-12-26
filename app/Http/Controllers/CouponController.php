<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Provider;
use App\Models\Service;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class CouponController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $services = Service::get(['name','id']);
//
//        return  $services;
        if ($request->ajax()) {

//            $data = Coupon::with('service.categories','service.providers')->get();
            $data = Coupon::with('service')->get();

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('services', function($row) {
                    $lang = app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->service->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->service->name ?? '<span class="badge bg-warning text-light">un defined</span>';
                    }

                })->addColumn('dis_b', function($row) {
                    $lang = app()->getLocale();
                    if ($lang == 'ar') {
                        if ($row->discount_type == 0) {
                            return '<span class="badge bg-primary text-light">ثابت</span>';
                        } elseif ($row->discount_type == 1)
                            return '<span class="badge bg-dark text-light">نسبة مئوية</span>';
                    }elseif ($lang == 'en'){
                        if ($row->discount_type == 0) {
                            return '<span class="badge bg-primary text-light">constant</span>';
                        } elseif ($row->discount_type == 1)
                            return '<span class="badge bg-dark text-light">per cent</span>';

                    }

                })->addColumn('sate', function($row) {
                    $lang = app()->getLocale();
                    if ($lang == 'ar') {
                        if ($row->enable == 1) {
                            return '<span class="badge bg-info text-light">فعالة</span>';
                        }
                        return '<span class="badge bg-warning text-light">غير فعالة</span>';
                    }elseif ($lang =='en'){
                        if ($row->enable == 1) {
                            return '<span class="badge bg-info text-light">enable</span>';
                        }
                        return '<span class="badge bg-warning text-light">un enable </span>';

                    }

                })->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    return $btn;

                })

                ->rawColumns(['action','services','dis_b','sate'])

                ->make(true);

            return;
        }

        $lang = app()->getLocale();
        $serv = Service::where('lang',$lang)->get(['name','id']);
        $state_id =Coupon::get(['enable']);
        return view('admin.coupons.add_coupon',compact('serv','state_id'));
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
        $validateErrors = Validator::make($request->all(),[

            'code' => 'required|string|min:3',
            'discount' => 'required',
            'discount_type' => 'required',
            'service_id' => 'required'
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }

        $data =[
            'code' => $request->code,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'service_id' => $request->service_id,
            'enable' => $request->enable
        ];

        $id =  Coupon::updateOrCreate(['id' => $request->_id],
            $data)->id;

        return response()->json(['status'=>200,'message' => 'تم الحفظ بنجاح' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
        return $this->editController(Coupon::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(Coupon::class,$id);
    }

    //filter services
    public function getServices(Request $request, $id)
    {
        //
        $services = Service::where('provider_id', '=', $id)->get(['name','id']);
        return response()->json($services);

    }
}

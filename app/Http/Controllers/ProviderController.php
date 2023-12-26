<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Validator;

class ProviderController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            //two condition with where where([['role','=',2],['status','=',0]])
            $data = User::where('accept',0)->where('role_id',3)->get();
//            return  $data;
            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    if($row->accept == 0){
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Accept" class="btn btn-warning btn-sm accept" title="قبول"> <i class="fa fa-check-circle"></i> </a>';
                    }else if($row->accept == 1){
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Reject" class="btn btn-success btn-sm reject" title="reject"> <i class="fa fa-minus"></i> </a>';
                    }
                    return $btn;

                })
                ->addColumn('available', function($row) {
                    $lang = app()->getLocale();
                    if($lang == 'ar') {
                        if ($row->available == 0) {
                            return '<span class="badge bg-warning text-light">غير متوفر</span>';
                        }
                        return '<span class="badge bg-success text-light">متوفر</span>';
                    }elseif ($lang == 'en'){
                        if ($row->available == 0) {
                            return '<span class="badge bg-warning text-light">un available</span>';
                        }
                        return '<span class="badge bg-success text-light">available</span>';
                    }

                })

                ->addColumn('icon',function ($row){
                    if(!empty($row->icon) && strlen($row->icon) > 5){
                        return "<img src='".asset($row->icon)."' width='50' height='50'>";
                    }
                    return "<img src='".asset('/img/amrak_tm.png')."' width='50' height='50'>";
                })


                ->rawColumns(['action','icon','available'])

                ->make(true);

            return;
        }
        return view('admin.providers.providers');
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

            'name' => 'required|string|min:3',
            'email' => 'required',
//            'icon' => 'required',
            'mobile' => 'required'
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }

        $data =[
            'name' => $request->name,
//            'icon' => $request->icon,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'available' => $request->available,
            'availability_rang' => $request->availability_rang,
            'role_id'=>3
        ];

        $id =  User::updateOrCreate(['id' => $request->_id],
            $data)->id;

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
        return $this->editController(User::class,$id);

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
        return $this->destroyController(User::class,$id);
    }

    public function acceptableProviders(Request $request)
    {
        if ($request->ajax()) {

            //two condition with where where([['role','=',2],['status','=',0]])
            $data = User::where('accept',1)->where('role_id',3)->get();
//            return  $data;
            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Reject" class="btn btn-success btn-sm reject" title="reject"> <i class="fa fa-minus"></i> </a>';
                    return $btn;

                })
                ->addColumn('available', function($row) {
                    $lang = app()->getLocale();
                    if($lang == 'ar') {
                        if ($row->available == 0) {
                            return '<span class="badge bg-warning text-light">غير متوفر</span>';
                        }
                        return '<span class="badge bg-success text-light">متوفر</span>';
                    }elseif ($lang == 'en'){
                        if ($row->available == 0) {
                            return '<span class="badge bg-warning text-light">un available</span>';
                        }
                        return '<span class="badge bg-success text-light">available</span>';
                    }
                })
                ->addColumn('icon',function ($row){
                    if(!empty($row->icon) && strlen($row->icon) > 5){
                        return "<img src='".asset($row->icon)."' width='50' height='50'>";
                    }
                    return "<img src='".asset('/img/amrak_tm.png')."' width='50' height='50'>";
                })

                ->rawColumns(['action','icon','available'])

                ->make(true);

            return;
        }
        return view('admin.providers.accepted_providers');
    }

    public function agree(Request $request, $id)
    {
       return $this->accept($request, $id, User::class);
    }
}

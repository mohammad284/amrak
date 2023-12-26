<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class PaymentMethodController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = PaymentMethod::get();

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    $da = PaymentMethod::where('id',$row->trans_id)->pluck('id');
//
                    if($row->id == $da[0]->id){
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Add" class="btn btn-success btn-sm addTra"> <i class="fa fa-language"></i> </a>';

                    }else {

                    }
                    return $btn;

                })

                ->addColumn('state', function($row) {
                    if ($row->enable == 1) {
                        return '<span class="badge bg-success text-light">فعالة</span>';
                    }
                    return '<span class="badge bg-warning text-light">غير فعالة</span>';
                })
                ->rawColumns(['action','state'])

                ->make(true);

            return;
        }
        return view('admin.payment_method.index');
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validateErrors = Validator::make($request->all(),[

            'name' => 'required|string|min:3',
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }

        $data =[
            'name' => $request->name,
            'enable' => $request->enable,
            'lang' => $request->lang
        ];

        if(!empty($request->trans_id)){
            $data +=[
                'trans_id' => $request->trans_id,
            ];
            $id =  PaymentMethod::updateOrCreate(['id' => $request->_id],
                $data)->id;
        }else{

            $id =  PaymentMethod::updateOrCreate(['id' => $request->_id],
                $data)->id;
            PaymentMethod::where('id',$id)->update(['trans_id'=>$id]);

        }
//
//        $id =  PaymentMethod::updateOrCreate(['id' => $request->_id],
//            $data)->id;
//
//         PaymentMethod::where('id',$id)->updated(['trans_id'=>$id]);
        return response()->json(['status'=>200,'message' => ' Added successfully.' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $pay_st
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $pay_st)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $pay_st
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return $this->editController(PaymentMethod::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentMethod  $pay_st
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $pay_st)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentMethod $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(PaymentMethod::class,$id);
    }
}

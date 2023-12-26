<?php

namespace App\Http\Controllers;

use App\Models\PaymentState;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class PaymentStateController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lang = app()->getLocale();
        if ($request->ajax()) {

            $data = PaymentState::where('lang',$lang)->get();

            return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('lang', function($row) {
                    if($row->lang =='ar'){
                        return '<span class="badge bg-info text-light">عربية</span>';
                    }
                    return '<span class="badge bg-warning text-light">English</span>';

                })
                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';

                    return $btn;

                })


                ->rawColumns(['action','lang'])

                ->make(true);

            return;
        }
        return view('admin.payment_state.index');
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
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }

        $data =[
            'name' => $request->name,
            'lang' => $request->lang
        ];

        if(!empty($request->trans_id)){
            $data +=[
                'trans_id' => $request->trans_id,
            ];
            $id =  PaymentState::updateOrCreate(['id' => $request->_id],
                $data)->id;
        }else{

            $id =  PaymentState::updateOrCreate(['id' => $request->_id],
                $data)->id;
            PaymentState::where('id',$id)->update(['trans_id'=>$id]);

        }

        return response()->json(['status'=>200,'message' => ' Added successfully.' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentState  $pay_st
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentState $pay_st)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentState  $pay_st
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
        return $this->editController(PaymentState::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentState  $pay_st
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentState $pay_st)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentState $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(PaymentState::class,$id);
    }
}

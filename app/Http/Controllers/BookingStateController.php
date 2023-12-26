<?php

namespace App\Http\Controllers;

use App\Models\BookingState;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class BookingStateController extends Controller
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
        //
        if ($request->ajax()) {
            $lang = app()->getLocale();
            $data = BookingState::where('lang',$lang)->get();

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
        return view('admin.booking_statuses.booking_status');
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
            'lang' => 'required',
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }

        $data =[
            'name' => $request->name,
            'lang' => $request->lang,
        ];

        if(!empty($request->trans_id)){
            $data +=[
                'trans_id' => $request->trans_id,
            ];
            BookingState::updateOrCreate(['id' => $request->_id],
                $data);
        }else{

            $id =  BookingState::updateOrCreate(['id' => $request->_id],
                $data)->id;
            BookingState::where('id',$id)->update(['trans_id'=>$id]);

        }



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
        return $this->editController(BookingState::class,$id);
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
        return $this->destroyController(BookingState::class,$id);

    }
}

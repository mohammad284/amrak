<?php

namespace App\Http\Controllers;

use App\Models\AvailabilityHours;
use App\Models\Category;
use App\Models\Day;
use App\Models\Provider;
use App\Models\Service;
use App\Traits\Helper;
use DataTables;
use Validator;
use Illuminate\Http\Request;

class AvailabilityHoursController extends Controller
{
    use Helper;
    public function index(Request $request){
        if ($request->ajax()) {

            $data = AvailabilityHours::with('service')->with('day')->get();

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('service', function($row){
                    if(!empty($row->service_id))
                 {
                    return Service::find($row->service_id)->name ?? "Deleted";
                } else{
                    return Service::find($row->service_id)->name;
                }

                })
                ->addColumn('days', function($row){
                    if(!empty($row->day_id)){
                        return Day::find($row->day_id)->name ?? "Deleted";
                    } else{
                        return Day::find($row->day_id)->name;
                    }

                })
                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    return $btn;

                })

                ->rawColumns(['action','days','service'])

                ->make(true);

            return;
        }
        $lang = app()->getLocale();
        $service = Service::where('lang',$lang)->get(['name','id']);
        $day = Day::where('lang',$lang)->get(['name','id']);
        return view('admin.availability_hours.index',compact('service','day'));
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
        if( empty($request->_id)) {

            $validateErrors = Validator::make($request->all(),
                [
                    'service_id' => 'required',
                    'day_id' => 'required',


                ]);
            if ($validateErrors->fails()) {
                return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
            } // end if fails .
        }

        $data =[
            'service_id' => $request->service_id,
            'day_id' => $request->day_id,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
        ];

        $id =  AvailabilityHours::updateOrCreate(['id' => $request->_id],
            $data)->id;

        return response()->json(['status'=>200,'message' => ' تم حفظ البيانات  بنجاح .' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AvailabilityHours  $inbox
     * @return \Illuminate\Http\Response
     */
    public function show(AvailabilityHours $inbox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AvailabilityHours  $inbox
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return  $this->editController(AvailabilityHours::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AvailabilityHours  $inbox
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $item = AvailabilityHours::find($id);
        $validateErrors = Validator::make($request->all(),
            [
                'details' => 'required|string|min:3',
            ]);
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .

        return response()->json(['status'=>200,'message' => 'تم الحفظ بنجاح' ]);
//        $item->update($request->all());
//        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AvailabilityHours  $inbox
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->destroyController(AvailabilityHours::class,$id);
    }
}

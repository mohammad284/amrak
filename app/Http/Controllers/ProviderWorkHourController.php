<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Provider;
use App\Models\ProviderWorkHour;
use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Monolog\Handler\SyslogUdp\UdpSocket;
use Validator;

class ProviderWorkHourController extends Controller
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

            $data = ProviderWorkHour::get();

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('providers', function($row){
                    $lang =app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->providers->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    } elseif ($lang == 'en'){
                        return $row->provider->name ?? '<span class="badge bg-warning text-light">un defined</span>';
                    }

                })->addColumn('days', function($row) {
                    $lang =app()->getLocale();
                    if ($lang == 'ar'){
                        return $row->day->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    } elseif ($lang == 'en'){
                        return $row->day->name ?? '<span class="badge bg-warning text-light">un defined</span>';
                    }

                })
                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';

                    return $btn;

                })


                ->rawColumns(['action','providers','days'])

                ->make(true);

            return;
        }
        $provider = User::where('accept',1)->where('role_id',3)->get(['id','name']);
        $day = Day::get(['id','name']);
        return view('admin.providers.provider_wrk_hr',compact('day','provider'));
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

            'provider_id' => 'required',
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        }


        $data =[
            'details' => $request->details,
            'provider_id' => $request->provider_id,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'day_id' => $request->day_id
        ];

//
        ProviderWorkHour::updateOrCreate(['id' => $request->_id],
            $data)->id;

        return response()->json(['status'=>200,'message' => ' Added successfully.' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProviderWorkHour  $prov
     * @return \Illuminate\Http\Response
     */
    public function show(ProviderWorkHour $prov)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProviderWorkHour  $prov
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
        return $this->editController(ProviderWorkHour::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProviderWorkHour  $prov
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProviderWorkHour $prov)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProviderWorkHour $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(ProviderWorkHour::class,$id);
    }
//    public function agree(Request $request, $id)
//    {
//        return $this->accept($request, $id, ProviderWorkHour::class);
//    }

}

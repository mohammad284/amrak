<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Provider;
use App\Models\SubProv;
use App\Models\Subscriptions;
use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Monolog\Handler\SyslogUdp\UdpSocket;
use Validator;

class SubProvController extends Controller
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

            $data = SubProv::get();

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('subscript', function($row){
                    $lang = app()->getLocale();

                    if ($lang == 'ar'){
                        return $row->subscripts->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';

                    }elseif ($lang == 'en'){
                        return $row->subscripts->name ?? '<span class="badge bg-warning text-light">un defined</span>';

                    }

                })->addColumn('provider', function($row) {
                    $lang = app()->getLocale();

                    if ($lang == 'ar'){
                        return $row->providers->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';

                    }elseif ($lang == 'en'){
                        return $row->providers->name ?? '<span class="badge bg-warning text-light">un defined</span>';

                    }
                })
                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';

                    return $btn;

                })


                ->rawColumns(['action','provider','subscript'])

                ->make(true);

            return;
        }
        $providers = User::where('accept',1)->where('role_id',3)->get(['id','name']);
        $subscripts = Subscriptions::get(['id','name']);
        return view('admin.subscriptions.provider_subs',compact('subscripts','providers'));
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
            'provider_id' => $request->provider_id,
            'subscript_id' => $request->subscript_id
        ];

//
        SubProv::updateOrCreate(['id' => $request->_id],
            $data)->id;

        return response()->json(['status'=>200,'message' => ' Added successfully.' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubProv  $prov
     * @return \Illuminate\Http\Response
     */
    public function show(SubProv $prov)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubProv  $prov
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
        return $this->editController(SubProv::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubProv  $prov
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubProv $prov)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubProv $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(SubProv::class,$id);
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\ProviderReview;
use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Monolog\Handler\SyslogUdp\UdpSocket;
use Validator;

class ProviderReviewController extends Controller
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

            $data = ProviderReview::get();

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('provider', function($row){
                    $lang = app()->getLocale();
                    if($lang == 'ar') {
                        return $row->provider->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->provider->name ?? '<span class="badge bg-warning text-light">un defined</span>';
                    }



                })->addColumn('customer', function($row) {
                    $lang = app()->getLocale();
                    if($lang == 'ar') {
                        return $row->customer->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }
                    elseif ($lang == 'en'){
                        return $row->customer->name ?? '<span class="badge bg-warning text-light">un defined</span>';
                    }
                })
                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    if($row->accept == 0){
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Accept" class="btn btn-warning btn-sm accept" title="accept"> <i class="fa fa-check-circle"></i> </a>';
                    }else if($row->accept == 1){
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Reject" class="btn btn-success btn-sm reject" title="reject"> <i class="fa fa-minus"></i> </a>';
                    }
                    return $btn;

                })


                ->rawColumns(['action','provider','customer'])

                ->make(true);

            return;
        }
        $provider = User::where('accept',1)->where('role_id',3)->get(['id','name']);
        $user = User::where('accept',1)->where('role_id',2)->get(['id','name']);
        return view('admin.providers.provider_review',compact('user','provider'));
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
        }

        $data =[
            'customer_id' => $request->customer_id,
            'provider_id' => $request->provider_id,
            'comment' => $request->comment,
            'rate' => $request->rate
        ];

//
         ProviderReview::updateOrCreate(['id' => $request->_id],
                $data)->id;

        return response()->json(['status'=>200,'message' => ' Added successfully.' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProviderReview  $prov
     * @return \Illuminate\Http\Response
     */
    public function show(ProviderReview $prov)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProviderReview  $prov
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
        return $this->editController(ProviderReview::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProviderReview  $prov
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProviderReview $prov)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProviderReview $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(ProviderReview::class,$id);
    }
    public function agree(Request $request, $id)
    {
        return $this->accept($request, $id, ProviderReview::class);
    }

}

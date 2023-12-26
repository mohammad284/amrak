<?php

namespace App\Http\Controllers;

use App\Models\ServiceReview;
use Illuminate\Http\Request;
use App\Traits\Helper;
use DataTables;
use Validator;

class ServiceViewController extends Controller
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

            $data = ServiceReview::with('services')->get();
//            return  $data;
            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    if($row->accept == 0){
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Accept" class="btn btn-warning btn-sm accept"> <i class="fa fa-check-circle"></i> </a>';
                    }else if($row->accept == 1){
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Reject" class="btn btn-success btn-sm reject"> <i class="fa fa-minus-circle"></i> </a>';
                    }
                    return $btn;

                })

                ->addColumn('service_id',function ($row){
                    if(!empty($row->services))
                        return $row->services->name ?? "Deleted";
                })

                ->rawColumns(['action','service_id'])

                ->make(true);

            return;
        }
        return view('admin.services_review.index');
    }

    public function acceptableUsers(Request $request){
        if ($request->ajax()) {

            //two condition with where where([['role','=',2],['status','=',0]])
            $data = ServiceReview::where('accept',1)->get();
//            return  $data;
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Reject" class="btn btn-success btn-sm reject"> <i class="fa fa-check-circle"></i> </a>';

                    return $btn;

                })

                ->addColumn('icon',function ($row){

                    return "<img src='".asset('storage/'.$row->icon)."' width='50' height='50'>";
                })

                ->rawColumns(['action','icon'])

                ->make(true);

            return;
        }
        return view('admin.services.index');
    }
    public function agree(Request $request, $id)
    {
        return $this->accept($request, $id, ServiceReview::class);
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

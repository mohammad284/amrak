<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class UserAddressController  extends Controller
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

            $data = UserAddress::get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('customer', function($row){
                    $lang =app()->getLocale();
                    if ($lang == 'ar') {
                        return $row->user->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }
                    return $row->user->name ?? '<span class="badge bg-warning text-light">undefined</span>';

                })
                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
//                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-primary btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    return $btn;

                })

                ->rawColumns(['action'])

                ->make(true);

            return;
        }
        return view('admin.users.user_address');
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

            'user_id' => 'required|string|min:3',
            'address' => 'required',
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }
        $data =[
            'user_id' => $request->user_id,
            'address' => $request->service_id
        ];

        $id =  UserAddress::updateOrCreate(['id' => $request->_id],
            $data)->id;


        return response()->json(['status'=>200,'message' => ' Added successfully.' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAddress  $userfav
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $userfav)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAddress  $userfav
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
        return $this->editController(UserAddress::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAddress  $userfav
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $userfav)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAddress  $userfav
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(UserAddress::class,$id);
    }
}

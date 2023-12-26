<?php

namespace App\Http\Controllers;

use App\Models\ConditionRoles;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Validator;

class RoleConditionController  extends Controller
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
            $lang = app()->getLocale();
            $data = ConditionRoles::where('lang',$lang)->latest()->get();

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';

                    return $btn;

                })

                ->rawColumns(['action'])

                ->make(true);

            return;
        }

        return view('admin.role_conditions.index');
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
    public function add_new_role()
    {
        return view('admin.role_conditions.add_cond');
    }

    public function update_role(Request $request){

        $validateErrors = Validator::make($request->all(),
            [
                'title' => 'required',
            ]);
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        }

        $data =[
            'title' => $request->title,
            'content' => $request->content1
        ];
        ConditionRoles::updateOrCreate(['id' => $request->_id],
            $data)->id;

        return response()->json(['status'=>200,'message' => 'تم الحفظ بنجاح' ]);


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

        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }
        $lang = app()->getLocale();


        if($lang == 'ar'){
            $data =[
                'title' => $request->title_ar,
                'content' => $request->text_ar,
                'lang' => $lang
            ];

            ConditionRoles::updateOrCreate(['id' => $request->_id],
                $data)->id;

            $data_en=[
                'title' => $request->title_en,
                'content' => $request->text_en,
                'lang' => 'en'

            ];

            ConditionRoles::create(
                $data_en);
        }

        if($lang == 'en'){
            $data =[
                'title' => $request->title_en,
                'content' => $request->text_en,
                'lang' => $lang
            ];

            ConditionRoles::updateOrCreate(['id' => $request->_id],
                $data)->id;
            //ar
            $data_ar=[
                'title' => $request->title_ar,
                'content' => $request->text_ar,
                'lang' => 'ar'

            ];


            ConditionRoles::create(
                $data_ar);
        }
        return response()->json(['status'=>200,'message' => ' Added successfully.' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConditionRoles  $role
     * @return \Illuminate\Http\Response
     */
    public function show(ConditionRoles $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConditionRoles  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
        return $this->editController(ConditionRoles::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConditionRoles  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConditionRoles $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConditionRoles  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(ConditionRoles::class,$id);
    }
}

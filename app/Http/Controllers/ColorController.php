<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class ColorController extends Controller
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

            $data = Color::get();

            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('value',function ($row){
                    return '<span>'.$row->value.'</span>&nbsp;<span><i class="fa fa-circle fa-lg" style="color: '.$row->value.'"></i></span>';

                })->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    return $btn;

                })

                ->rawColumns(['action','value'])

                ->make(true);

            return;
        }
        return view('admin.color.add_color');
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
            'value' => 'required',
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }

        $data =[
            'name' => $request->name,
            'value' => $request->value,
        ];

        $id =  Color::updateOrCreate(['id' => $request->_id],
            $data)->id;

        return response()->json(['status'=>200,'message' => ' تم الحفظ بنجاح' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        //
        return $this->editController(Color::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Color $color)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Color  $color
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(Color::class,$id);
    }
}

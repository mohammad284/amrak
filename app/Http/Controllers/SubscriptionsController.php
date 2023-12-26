<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use App\Traits\Helper;
use DataTables;
use Validator;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{

    use Helper;
    public function index(Request $request){
        $lang = app()->getLocale();
        if ($request->ajax()) {

            $data = Subscriptions::where('lang',$lang)->get();

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    return $btn;

                })

                ->rawColumns(['action',])

                ->make(true);

            return;
        }

        return view('admin.subscriptions.index');
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
    public function update_sub(Request $request){

        $validateErrors = Validator::make($request->all(),
            [
                'name' => 'required',

            ]);
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }
//        $data = [];

        $data =[
            'name' => $request->name,
            'max_adv' => $request->max_adv,
            'max_service' => $request->max_service,
            'duration' => $request->duration,
            'price' => $request->price,
        ];
        Subscriptions::updateOrCreate(['id' => $request->_id],
            $data)->id;

        return response()->json(['status'=>200,'message' => 'تم الحفظ بنجاح' ]);


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        return  ;
        if( empty($request->_id)) {

            $validateErrors = Validator::make($request->all(),
                [
                    'price' => 'required',


                ]);
            if ($validateErrors->fails()) {
                return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
            } // end if fails .
        }
       $lang = app()->getLocale();

        $data =[
            'max_adv' => $request->max_adv,
            'max_service' => $request->max_service,
            'duration' => $request->duration,
            'price' => $request->price,
        ];

        if($lang == 'ar'){
            $data +=[
                'name' => $request->name_ar,
                'lang' => $lang
            ];

            Subscriptions::updateOrCreate(['id' => $request->_id],
                $data)->id;

            $data_en=[
                'name' => $request->name_en,
                'max_adv' => $request->max_adv,
                'max_service' => $request->max_service,
                'duration' => $request->duration,
                'price' => $request->price,
                'lang' => 'en',

            ];

            Subscriptions::create(
                $data_en);
        };
//        Subscriptions::updateOrCreate(['id' => $request->_id],
//            $data)->id;

        if($lang == 'en'){
            $data +=[
                'name' => $request->name_en,
                'lang' => $lang
            ];

         Subscriptions::updateOrCreate(['id' => $request->_id],
                $data)->id;
            //ar
            $data_ar=[
                'name' => $request->name_en,
                'max_adv' => $request->max_adv,
                'max_service' => $request->max_service,
                'duration' => $request->duration,
                'price' => $request->price,
                'lang' => 'ar',

            ];


            Subscriptions::create(
                $data_ar);
        };
        return response()->json(['status'=>200,'message' => ' تم حفظ البيانات  بنجاح .' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscriptions  $subs
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriptions $subs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscriptions  $subs
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return  $this->editController(Subscriptions::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscriptions  $subs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $item = Subscriptions::find($id);
        $validateErrors = Validator::make($request->all(),
            [
                'details' => 'required|string|min:3',


            ]);
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        $item->update($request->all());
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscriptions  $subs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->destroyController(Subscriptions::class,$id);
    }
}

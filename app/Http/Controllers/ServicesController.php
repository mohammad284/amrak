<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Provider;
use App\Models\Service;
use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class ServicesController extends Controller
{
    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $lang = app()->getLocale();
            $data = Service::where('available',1)->where('lang',$lang)->with('providers')->with('categories')->get();
            $data_en =  Service::where('available',1)->where('lang','en')->with('providers')->with('categories')->get();
            // dd($data_en );
            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('provider_id', function($row){
                    $lang = app()->getLocale();

                    if ($lang == 'ar'){
                        return $row->providers->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';

                    }elseif ($lang == 'en'){
                        return $row->providers->name ?? '<span class="badge bg-warning text-light">un defined</span>';

                    }

                })->addColumn('cat_id', function($row){
                    $lang = app()->getLocale();
                    if ($lang == 'ar'){
                    return $row->categories->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }elseif ($lang == 'en'){
                        return $row->categories->name ?? '<span class="badge bg-warning text-light">un defined</span>';
                    }
                })->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'"  data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    return $btn;

                })

                ->addColumn('icon',function ($row){
                    if(!empty($row->icon) && strlen($row->icon) > 5){
                        return "<img src='".asset($row->icon)."' width='50' height='50'>";
                    }
                    return "<img src='".asset('/img/amrak_tm.png')."' width='50' height='50'>";
                })

                ->rawColumns(['action','icon','provider_id','cat_id'])

                ->make(true);

            return;
        }
        $lang = app()->getLocale();
        $providers = User::where('accept',1)->where('role_id',3)->get(['id','name']);
        $categories = Category::where('lang',$lang)->get(['name','id']);
        return view('admin.services.services',compact('providers','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
     }
    public function add_new_serv()
    {   $lang = app()->getLocale();
        $providers = User::where('accept',1)->where('role_id',3)->get(['id','name']);
        $categories = Category::where('lang',$lang)->get(['name','id']);
        return view('admin.services.add_serv',compact('categories','providers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

           $lang = app()->getLocale();
        $validateErrors = Validator::make($request->all(),[

            'provider_id' => 'required',
            'icon' => 'required',
            'cat_id' => 'required',
            'price' => 'required',
            'price_unit' => 'required',
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        }

        
        $data = [
            'icon' => $request->icon,
            'provider_id' => $request->provider_id,
            'cat_id' => $request->cat_id,
            'price' => $request->price,
            'duration' => $request->duration,
            'price_unit' => $request->price_unit,
            'discount' => $request->discount,
            'tax' => $request->tax
        ];
        // if($lang == 'ar'){
            $data +=[
                'name' => $request->name_ar,
                'hint' => $request->hint_ar,
                'description' => $request->description_ar,
                'lang' => 'ar'
            ];
            
//
            $data_ar = Service::updateOrCreate(['id' => $request->_id],
                $data)->id;
            $data_en=[
                'name' => $request->name_en,
                'icon' => $request->icon,
                'provider_id' => $request->provider_id,
                'cat_id' => $request->cat_id,
                'price' => $request->price,
                'hint' => $request->hint_en,
                'description' => $request->description_en,
                'duration' => $request->duration,
                'price_unit' => $request->price_unit,
                'discount' => $request->discount,
                'tax' => $request->tax,
                'lang' => 'en',
                'ar_id' => $data_ar
            ];

            Service::create(
                $data_en);
        // };
        // if($lang == 'en'){
        //     $data +=[
        //         'name' => $request->name_en,
        //         'hint' => $request->hint_en,
        //         'description' => $request->description_en,
        //         'lang' => $lang
        //     ];

        //     $id_tr =  Service::updateOrCreate(['id' => $request->_id],
        //         $data)->id;
        //     //ar
        //     $data_ar=[
        //         'name' => $request->name_ar,
        //         'icon' => $request->icon,
        //         'provider_id' => $request->provider_id,
        //         'cat_id' => $request->cat_id,
        //         'price' => $request->price,
        //         'hint' => $request->hint_ar,
        //         'description' => $request->description_ar,
        //         'duration' => $request->duration,
        //         'price_unit' => $request->price_unit,
        //         'discount' => $request->discount,
        //         'tax' => $request->tax,
        //         'lang' => 'ar',

        //     ];


        //     Service::create(
        //         $data_ar);
        // };
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
        return $this->editController(Service::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
       }

       public function update_serv(Request $request){
           $validateErrors = Validator::make($request->all(),[

               'provider_id' => 'required',
               'icon' => 'required',
               'cat_id' => 'required',
               'price' => 'required',
               'price_unit' => 'required',
           ]);

           if ($validateErrors->fails()) {
               return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
           }
           $service = Service::find($request->_id);
           if($service->ar_id == null){
                $service_ar = $service;
                $service_en = Service::where('ar_id',$service_ar->id)->first();
            }else{
                $service_en = $service;
                $service_ar = Service::where('id',$service_en->ar_id)->first();
            }
        //    dd($service_ar);
           $data_ar = [
               'name' => $request->name_ar,
               'icon' => $request->icon,
               'provider_id' => $request->provider_id,
               'cat_id' => $request->cat_id,
               'price' => $request->price,
               'hint' => $request->hint_ar,
               'description' => $request->description_ar,
               'duration' => $request->duration,
               'price_unit' => $request->price_unit,
               'discount' => $request->discount,
               'tax' => $request->tax
           ];
           $data_en = [
            'name' => $request->name_en,
            'icon' => $request->icon,
            'provider_id' => $request->provider_id,
            'cat_id' => $request->cat_id,
            'price' => $request->price,
            'hint' => $request->hint_en,
            'description' => $request->description_en,
            'duration' => $request->duration,
            'price_unit' => $request->price_unit,
            'discount' => $request->discount,
            'tax' => $request->tax
        ];
        $service_ar->update($data_ar);
        $service_en->update($data_en);
        //    Service::updateOrCreate(['id' => $request->_id],
        //        $data)->id;

           return response()->json(['status'=>200,'message' => 'تم الحفظ بنجاح' ]);


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
        return $this->destroyController(Service::class,$id);
    }
    //filter service with category
    public function filter( Request $request, $cat_id)
    {
        $lang =app()->getLocale();
//        $data = Service::with('stars')->with('prices')->where([['cat_id', '=', $cat_id]])->get();
        $data = Service::where('available',1)->where('lang',$lang)->with('providers')->where([['cat_id', '=', $cat_id]])->get();
        if ($request->ajax()) {


            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('provider_id', function($row){
                    return $row->providers->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';

                })->addColumn('cat_id', function($row){
                    return $row->categories->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';

                })->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    return $btn;

                })

                ->addColumn('icon',function ($row){
                    if(!empty($row->icon) && strlen($row->icon) > 5){
                        return "<img src='".asset($row->icon)."' width='50' height='50'>";
                    }
                    return "<img src='".asset('/img/amrak_tm.png')."' width='50' height='50'>";
                })

                ->rawColumns(['action','icon','provider_id','cat_id'])

                ->make(true);

            return;
        }

        $providers = User::where('accept',1)->where('role_id',3)->get(['name','id']);
        $categories = Category::with('childs')->get(['name','id']);

        return view('admin.services.services',compact('providers','categories'));
    }

}

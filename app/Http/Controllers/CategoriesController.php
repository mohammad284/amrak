<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Traits\Helper;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Validator;
use DataTables;
use Image;

class CategoriesController extends Controller
{ use Helper;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

    public function index( Request $request)
    {
        $lang = app()->getLocale();
        if ($request->ajax()) {

            $data = Category::where('lang',$lang)->with('color')->with(array('childs' => function($query) {
                $query->select('name','icon','parent_id');
            }))->get();
            // dd($data);
            return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('color',function ($row){
                    $val =Color::find($row->color_id)->value;
                    return '<span>'.$val.'</span>&nbsp;<span><i class="fa fa-circle fa-lg" style="color: '.$val.'"></i></span>';

                })
                ->addColumn('background',function ($row){
                    $val =Color::find($row->background_color)->value;
                    return '<span>'.$val.'</span>&nbsp;<span><i class="fa fa-circle fa-lg" style="color: '.$val.'"></i></span>';

                })
                ->addColumn('font',function ($row){
                    $val =Color::find($row->font_color)->value;
                    return '<span>'.$val.'</span>&nbsp;<span><i class="fa fa-circle fa-lg" style="color: '.$val.'"></i></span>';

                })
                ->addColumn('state', function($row) {
                   $lang = app()->getLocale();
                   if ($lang == 'ar') {
                       if ($row->featured == 1) {

                           return '<span class="badge bg-success text-light">مميزة</span>';
                       }
                       return '<span class="badge bg-primary text-light">غير مميزة</span>';
                   }
                   elseif ($lang =='en')
                   {
                       if ($row->featured == 1) {

                           return '<span class="badge bg-success text-light">featured</span>';
                       }
                       return '<span class="badge bg-primary text-light">not featured</span>';
                   }
                })

                ->addColumn('parent', function($row) {
                    $lang = app()->getLocale();
                    if ($lang == 'ar') {
                        return $row->childs[0]->name ?? '<span class="badge bg-warning text-light">غير محدد</span>';
                    }else{
                        return $row->childs[0]->name ?? '<span class="badge bg-warning text-light">undefined</span>';

                    }
                })
                    ->addColumn('action',function ($row){

                    $btn = ' <a  href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a> &nbsp;';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a> &nbsp;';

                    return $btn;

                })
            ->addColumn('icon',function ($row){
                if(!empty($row->icon) && strlen($row->icon) > 5){
                    return "<img src='".asset($row->icon)."' width='50' height='50'>";
                }
                return "<img src='".asset('/img/amrak_tm.png')."' width='50' height='50'>";
                })

                ->rawColumns(['action','icon','color','parent','background','font','state'])

                ->make(true);
        }
        
        $colors = Color::get(['name','id']);
        $cats = Category::where('parent_id',0)->where('lang',$lang)->get(['name','id']);
        // dd($cats);

        return view('admin.categories.index',compact('cats','colors'));
    }


   public function add_new_cat()
    {   $lang = app()->getLocale();
        $colors = Color::get(['name','id']);
        $cats = Category::where('parent_id',0)->where('lang',$lang)->get(['name','id']);
        return view('admin.categories.add_cat',compact('cats','colors'));
    }

    public function update_cat(Request $request){

        $validateErrors = Validator::make($request->all(),
            [
                'icon' => 'required',

            ]);
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
        $data = [];

        if(!empty($request->parent_id)){
            $data["parent_id"]= $request->parent_id;
        }

        $data_ar =[

            'icon' => $request->icon,
            'name' => $request->name_ar,
            'color_id'=>$request->color_id,
            'background_color'=>$request->background_color,
            'font_color'=>$request->font_color,
            'featured'=>$request->featured,

        ];
        $data_en =[

            'icon' => $request->icon,
            'name' => $request->name_en,
            'color_id'=>$request->color_id,
            'background_color'=>$request->background_color,
            'font_color'=>$request->font_color,
            'featured'=>$request->featured,

        ];
        $category = Category::find($request->_id);
        if($category->ar_id == null){
            $category_ar = $category;
            $category_en = Category::where('ar_id',$category_ar->id)->first();
        }else{
            $category_en = $category;
            $category_ar = Category::where('id',$category_en->ar_id)->first();
        }
        $category_ar->update($data_ar);
        $category_en->update($data_en);
        // dd($category);
        Category::updateOrCreate(['id' => $request->_id],
            $data)->id;

        return response()->json(['status'=>200,'message' => 'تم الحفظ بنجاح' ]);


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
        $lang = app()->getLocale();

        $validateErrors = Validator::make($request->all(),
            [
//                'name ' => 'required|string|min:3',
                'icon' => 'required',

            ]);
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }
        $data_ar = [];

        if(!empty($request->parent_id)){
            $data_ar["parent_id"]= $request->parent_id;
        }


        // if($lang == 'ar'){
            $data_ar=[

            'icon' => $request->icon,
            'name' => $request->name_ar,
            'color_id'=>$request->color_id,
            'background_color'=>$request->background_color,
            'font_color'=>$request->font_color,
            'featured'=>$request->featured,
            'order_id'=>0,
            'lang' =>'ar'

        ];
            $parent_id = Category::where('id',$request->_id)->pluck('parent_id');
            if(!empty($request->$parent_id)){

                $data_ar +=[
                    'parent_id'=>$parent_id
                ];
            }
            $id_tr =  Category::updateOrCreate(['id' => $request->_id],
                $data_ar)->id;
            $data_en=[
                'icon' => $request->icon,
                'name' => $request->name_en,
                'color_id'=>$request->color_id,
                'font_color'=>$request->font_color,
                'background_color'=>$request->background_color,
                'featured'=>$request->featured,
                'order_id'=>0,
                'lang' =>'en',
                'ar_id'=>$id_tr
            ];

            $parent_id = Category::where('id',$request->_id)->pluck('parent_id');

            if(!empty($request->$parent_id)){

                $data_en +=[
                    'parent_id'=>$parent_id,
                    'trans_id'=>$id_tr
                ];
            }

            $vbf =Category::create(
                $data_en)->id;

        // }
        // if($lang == 'en'){
        //     $data_en=[

        //         'icon' => $request->icon,
        //         'name' => $request->name_en,
        //         'color_id'=>$request->color_id,
        //         'background_color'=>$request->background_color,
        //         'font_color'=>$request->font_color,
        //         'featured'=>$request->featured,
        //         'order_id'=>0,
        //         'lang' =>$lang

        //     ];
        //     $parent_id = Category::where('id',$request->_id)->pluck('parent_id');
        //     if(!empty($request->$parent_id)){

        //         $data_en +=[
        //             'parent_id'=>$parent_id
        //         ];
        //     }
        //     $id_tr =  Category::updateOrCreate(['id' => $request->_id],
        //         $data_en)->id;

        //     //ar
        //     $data_ar=[
        //         'icon' => $request->icon,
        //         'name' => $request->name_ar,
        //         'color_id'=>$request->color_id,
        //         'font_color'=>$request->font_color,
        //         'background_color'=>$request->background_color,
        //         'featured'=>$request->featured,
        //         'order_id'=>0,
        //         'lang' =>'ar'

        //     ];

        //     $parent_id = Category::where('id',$request->_id)->pluck('parent_id');

        //     if(!empty($request->$parent_id)){

        //         $data_ar +=[
        //             'parent_id'=>$parent_id,
        //             'trans_id'=>$id_tr
        //         ];
        //     }

        //       Category::create(
        //           $data_ar)->id;
        // }
        return response()->json(['status'=>200,'message' => "added successfully !"]);

        // return response()->json(['status'=>200,'message' => "'.{{__('add_succ')}}.'" , "data"=>Category::where('parent_id','=',$request->cat_id)->orderby('order_id')->get() ]);
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
        $item = Category::find($id);

        return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return  $this->editController(Category::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {

        $validateErrors = Validator::make($request->all(),
            [
                'name' => 'required|string|min:3',


            ]);
        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .

        $data =[
            'name' => $request->name,
            'icon' => $request->icon,

        ];

        Category::updateOrCreate(['id' => $request->_id],
            $data);


        return response()->json(['status'=>200,'message' => ' تم حفظ البيانات بنجاح.' ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->destroyController(Category::class,$id);

    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookNotify;
use App\Models\Category;
use App\Models\Color;
use App\Models\Provider;
use App\Models\Service;
use App\Models\ServiceReview;
use App\Models\Slider;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserFav;
use App\Traits\Helper;
use Session;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;
use Validator;

class AppSettingController extends Controller
{
    use Helper;

    public function home(){
        $user =User::all()->count();
        $pro =Provider::all()->count();
        $serv =Service::all()->count();
        $earning=Booking::all()->count();
        $arningl =DB::select("SELECT SUM(bookings.total) FROM bookings WHERE bookings.accept = 1 ");
        $book =Booking::all()->count();
        $cat =Category::all()->count();
        $notify=BookNotify::all()->count();
        $rev =ServiceReview::all()->count();
        $add =UserAddress::all()->count();
        $fav =UserFav::all()->count();
        return view('admin.home',compact('user','pro','cat','serv','book','earning','notify','rev','add','fav'));
    }
    public function getLocal(){
        if ( Session::get("locale") == "en") {

            Session::put('locale', 'ar');

            App::setLocale('ar');
            return back();

        }elseif (Session::get("locale") == "ar"){

            Session::put('locale', 'en');
            App::setLocale('en');
            return back();

        }

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = Slider::get();

            return Datatables::of($data)

                ->addIndexColumn()

//                ->addColumn('background',function ($row){
//                    $val =Color::find($row->background_color)->value;
//                    return '<span>'.$val.'</span>&nbsp;<span><i class="fa fa-circle fa-lg" style="color: '.$val.'"></i></span>';
//
//                })
                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    return $btn;

                })
                ->addColumn('image_service',function ($row){
                    return "<img src='".asset($row->image_service)."' width='50' height='50'>";

                })
                ->rawColumns(['action','image_service'])

                ->make(true);

            return;
        }
        return view('admin.slides.slider');
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
            'text' => 'required|string|min:3',
            'btn' => 'required',
            'text_color' => 'required',
            'btn_color' => 'required',
            'background_color' => 'required',
            'indicator_color' => 'required',
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }
//image_service
        $data =[

            'text' => $request->text,
            'btn' => $request->btn,
            'text_color' => $request->text_color,
            'btn_color' => $request->btn_color,
            'background_color' => $request->background_color,
            'indicator_color' => $request->indicator_color,
            'image_service' => $request->image_service,
            'enable' => 0
        ];

        $id =  Slider::updateOrCreate(['id' => $request->_id],
            $data)->id;

        return response()->json(['status'=>200,'message' => ' Added successfully.' ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return $this->editController(Slider::class,$id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(Slider::class,$id);
    }
    public function service_image(Request $request){
        if($request->file('file')){
            $image=$request->file('file');
            $input['file'] = $image->getClientOriginalName();
            $path = 'images/category/';
            $destinationPath = 'images/slider';
            $img = Image::make($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.time().$input['file']);
            $name = $path.time().$input['file'];
            
           $data['file'] =  $name;
        }
        return $name;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\Helper;
use Illuminate\Http\Request;
use DataTables;
use Validator;
use Kreait\Firebase\Auth\UserRecord;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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

            //two condition with where where([['role','=',2],['status','=',0]])
            $data = User::where('accept',0)->where('role_id',2)->get();
//            return  $data;
            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    if($row->accept == 0){
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Accept" class="btn btn-warning btn-sm accept" title="قبول"> <i class="fa fa-check-circle"></i> </a>';
                    }else if($row->accept == 1){
                        $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Reject" class="btn btn-success btn-sm reject" title="رفض"> <i class="fa fa-minus"></i> </a>';
                    }
                    return $btn;

                })

                ->addColumn('icon',function ($row){
                    if(!empty($row->icon) && strlen($row->icon) > 5){
                        return "<img src='".asset($row->icon)."' width='50' height='50'>";
                    }
                    return "<img src='".asset('/img/amrak_tm.png')."' width='50' height='50'>";
                })

                ->rawColumns(['action','icon'])

                ->make(true);

            return;
        }
        return view('admin.users.users');
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
            'email' => 'required',
//            'icon' => 'required',
            'mobile' => 'required'
        ]);

        if ($validateErrors->fails()) {
            return response()->json(['status' => 201, 'message' => $validateErrors->errors()->first()]);
        } // end if fails .
//        }

        $data =[
            'name' => $request->name,
//            'icon' => $request->icon,
            'emil' => $request->email,
            'mobile' => $request->mobile,
        ];

        $id =  User::updateOrCreate(['id' => $request->_id],
            $data)->id;

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
        return $this->editController(User::class,$id);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        return $this->destroyController(User::class,$id);

    }

    public function acceptableUsers(Request $request){
        if ($request->ajax()) {

            //two condition with where where([['role','=',2],['status','=',0]])
            $data = User::where('accept',1)->where('role_id',2)->get();
//            return  $data;
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function($row){

                    $btn = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm delete"> <i class="fa fa-trash"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-info btn-sm edit"> <i class="fa fa-edit"></i> </a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Reject" class="btn btn-success btn-sm reject" title="reject"> <i class="fa fa-minus"></i> </a>';

                    return $btn;

                })

                ->addColumn('icon',function ($row){
                    if(!empty($row->icon) && strlen($row->icon) > 5){
                        return "<img src='".asset($row->icon)."' width='50' height='50'>";
                    }
                    return "<img src='".asset('/img/amrak_tm.png')."' width='50' height='50'>";
                })

                ->rawColumns(['action','icon'])

                ->make(true);

            return;
        }
        return view('admin.users.accepted_users');
    }

    public function agree(Request $request, $id)
    {
        return $this->accept($request, $id, User::class);
    }

    public function loginForm(){
        if(!auth()){
            return redirect('/');
        }
        else{
            return redirect('/home');
        }
    }

    public function login(Request $request){
        $validateErrors = Validator::make($request->all(),
            [
                'email'=>'required|email',
                'password'=>'required',
            ]);

        if ($validateErrors->fails()) {
            return redirect()->back()->withErrors($validateErrors->errors()->first())->withInput();
        }

        if(Auth::attempt([
            "email"=>$request->email,
            "password"=>$request->password
        ])){
            return redirect()->route('home');
        }
        else{
            return redirect()->back()->withErrors('خطأ في بيانات الدخول')->withInput();


        }
    }

    public function showProfile(Request $request){

            $user = Auth()->user();
            return view("profile", compact('user'));

    }
    public function updateProfile(Request $request){

        $user = Auth()->user();
        $check = User::where([['id','!=',$user->id],['email','=',$request->email]])->count();
        if($check > 0){
            return response()->json(['status'=>201]);
        }

        $user->name = $request->input("name");
        $user->email = $request->input("email");
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return response()->json(['status'=>200]);


    }
    public function logout()
    {
        auth()->logout();

        return redirect('/');
    }

}

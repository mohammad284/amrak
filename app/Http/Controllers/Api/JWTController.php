<?php

namespace App\Http\Controllers\Api;

use App\Models\Provider;
use Auth;
use Illuminate\Support\Facades\Storage;
use Image;
//use Intervention\Image\Facades\Image;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class JWTController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login', 'register']]);
    // }

    /**
     * Register user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
            'mobile' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        if ($request['image'] == NUll){
            $data['image'] = 'images/avatar.jpg';
        }
        if($request->file('image')){
            $image=$request->file('image');
            $input['image'] = $image->getClientOriginalName();
            $path = 'images/user/';
            $destinationPath = 'images/user';
            $img = Image::make($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.time().$input['image']);
            $name = $path.time().$input['image'];
            
           $data['image'] =  $name;
        }

        $user =[
            'name'   => $request->name,
            'mobile' => $request->mobile,
            'role_id'=> $request->role_id,
            'icon'   => $data['image'],
            'hint'=>$request->hint,
            'phone' => $request->phone
        ];

        if(!empty($request->input("password"))){
            $user['password'] = Hash::make($request->password);
        }
        if(!empty($request->input("email"))){
            $user['email'] = $request->email;
        }
        if(!empty($request->input("hint"))){
            $user['hint'] = $request->hint;
        }
        if(!empty($request->input("available"))){
            $user['available'] = $request->available;
        }
        if(!empty($request->input("address"))){
            $user['address'] = $request->address;
        }
        if(!empty($request->input("availability_rang"))){
            $user['availability_rang'] = $request->availability_rang;
        }
            $data =  User::create(
                $user
            );

        return response()->json([
            'message' => 'User successfully registered',
        ], 201);
    }

    public function update_user(Request $request){
            $user_id = $request->input('id');
            $user = User::where('id',$user_id)->first();
            if ($user->email != $request->email) {
                $simular_email = User::where('email',$request->email)->get();
                if (count($simular_email) > 0) {
                    return response()->json(['message' => 'email has taken']);
                }   
            }
            $validator = Validator::make($request->all(), [
                'name'      => ['required', 'string', 'max:255'],
                'mobile'    => ['required'],
            ]);
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            if ($request['image'] == NUll){
                $data['image'] = $user->icon;
            }
            if($request->file('image')){
                $image=$request->file('image');
                $input['image'] = $image->getClientOriginalName();
                $path = 'images/user/';
                $destinationPath = 'images/user';
                $img = Image::make($image->getRealPath());
                $img->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.time().$input['image']);
                $name = $path.time().$input['image'];
                
               $data['image'] =  $name;
            }

            if($request->password != null){
                if (Hash::check($request->old_password, $user->password)) { 
                 } else {
                    return response()->json(['message' => 'Password does not match']);
                 }
                 $validator = Validator::make($request->all(), [
                    'password'  => ['required', 'string', 'min:6'],
                ]);
                if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
                }
                    $data = [
                        'name'          => $request['name'],
                        'email'         => $request['email'],
                        'mobile'        => $request['mobile'],
                        'password'      => Hash::make($request['password']),
                        'icon'         => $data['image'],
                        'hint'          => $request['hint'],

                    ];
                }else{
                $data = [
                    'name'          => $request['name'],
                    'email'         => $request['email'],
                    'mobile'        => $request['mobile'],
                    'icon'         => $data['image'],
                    'hint'          => $request['hint'],
                    ];
                }
                User::where('id','=',$user_id)->update(
                    $data
                );
                return response()->json([
                    "status"=>200,
                    "data"=>User::find($user_id),
                    "message"=>"edit successfully !"
                ]);

//        }
    }

    /**
     * login user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $credentials = request(['email', 'password']);
        $token = auth()->guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token){
    
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 20,
            'user' => auth('api')->user()
        ]);
    }  

    /**
     * Logout user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'User successfully logged out.']);
    }

    /**
     * Refresh token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get user profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
//    public function profile()
//    {
//        return response()->json(auth()->user());
//    }

        public function profile(Request $request){
            $id=$request->input('id');
//            $id=$request->input('id');


              $data = User::where('id','=',$id)->get();


            return response()->json([
                'user' => $data
            ], 201);
        }
    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */

}

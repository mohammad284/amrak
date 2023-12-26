<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class ApiController extends Controller
{
    public function register(Request $request)
    {
        //Validate data
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
//role_id = 1 ->admin , 2 -> provider , 3 -> user
        //Request is valid, create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id'=>3,
            'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
        ], Response::HTTP_OK);
    }

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

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated, do logout
        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_user(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }
    public function update_user(Request $request){
        $id = $request->input('id');

        return response()->json($request);
        if(!empty($request->old_password) && !empty($request->password) ){

        $user = User::find($id);
        
         if(!Hash::check($request->input('old_password'), $user->first()->password)) {
                return response()->json([
                    "status"=>201,
                    "message"=>"كلمة السر القديمة غير صحيحة"
                ]);
            }
        }


        $data = [
            'name'=>$request->name,
            'mobile'=>$request->mobile,
            'hint'=>$request->hint,
            'mobile' => $request->phone
        ];
        if(!empty($request->input("email"))){
            $data['email'] = $request->email;
        }

    if(!empty($request->input('icon'))){

            ////
        $icon= base64_decode($request->input('icon'));

        $icon = str_replace('data:icon/jpeg;base64,', '', $icon);

        $name = "users". uniqid() . '_' .rand(1,1000000). '.'."png";
        $path = storage_path('users/uploads/');
        $ic= Storage::disk('public')->put('users/uploads' . $name , $icon);


        $user["icon"] = "users/uploads/". $name;
        $icon->move($path, $name);
      return response()->json([
          'name'          => $name,
          'original_name' => $icon->getClientOriginalName(),
          "img2"=>str_replace("/","_",$name)
      ]);
    }

        User::where('id','=',$id)->update(
            $data
        );

        return response()->json([
            "status"=>200,
            "data"=>User::find($id),
            "message"=>"edit successfully !"
        ]);
//        }
}
}

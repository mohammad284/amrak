<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Category;
use App\Models\Inquiries;
use App\Models\Requisitions;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    //
    public function storeMedia(Request $request , $table)
    {
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $name =  "";
        switch ($table){
            case "services":
                $name = "services". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                $path = public_path('images/services');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $name = "images/services/".$name;
                break;
            case "sliders":
                $name = "slide". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                $path = public_path('images/sliders');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $name = "images/sliders/".$name;
                break;
            case "user":
                $name = "user". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                $path = public_path('images/users');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $name = "images/users/".$name;
                break;

            case "categories":
                $name = "cat". uniqid() . '_' .rand(1,1000000). ".". strtolower($ext);
                $path = public_path('images/categories');
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $name = "images/categories/".$name;
                break;

        }

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
            "img2"=>str_replace("/","_",$name)
        ]);
    }



    public function destroyMedia($table, Request $request){
        switch ($table){
            case "services":
                $item = Service::find($request->service_id);
                $images = explode(",",$item->images);
                $key = array_search($request->image, $images);
                if($key !== false){

                    unset($images[$key]);
                }
                $images =implode(",",$images);

                Service::where('id','=',$request->service_id)->update(['images'=>$images]);
                return response()->json(["status"=>200,"images" =>$images, "img"=>$request->image , "img2"=>str_replace("/","_",$images)]);
                break;
            case "users":
                $item = User::find($request->user_id);
                $images = explode(",",$item->images);
                $key = array_search($request->image, $images);
                if($key !== false){

                    unset($images[$key]);
                }
                $images =implode(",",$images);

                User::where('id','=',$request->user_id)->update(['images'=>$images]);
                return response()->json(["status"=>200,"images" =>$images, "img"=>$request->image , "img2"=>str_replace("/","_",$images)]);
                break;
            case "categories":
                $item = Category::find($request->user_id);
                $images = explode(",",$item->images);
                $key = array_search($request->image, $images);
                if($key !== false){

                    unset($images[$key]);
                }
                $images =implode(",",$images);

                Category::where('id','=',$request->user_id)->update(['images'=>$images]);
                return response()->json(["status"=>200,"images" =>$images, "img"=>$request->image , "img2"=>str_replace("/","_",$images)]);
                break;
        }

    }

}

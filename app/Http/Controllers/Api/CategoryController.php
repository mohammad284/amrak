<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{


    //get all category with sub category
    public function all_category(Request $request)
    {
        $lang = $request->input('lang');
        $categories = Category::where('lang',$lang)->get();
        $data = [];
        foreach($categories as $category){
            $background_color = Color::where('id',$category->background_color)->first();
            $font_color = Color::where('id',$category->font_color)->first();
            $final = array('category'=>$category,'background_color'=>$background_color->value,'font_color'=>$font_color->value);
            array_push($data,$final);
        }
        // $data = Category::withCount('childs')->with('color')->with(array('childs' => function($query) {
        //     $query->select('id','name','icon','color_id','background_color','font_color','featured');
        // }))
        //     ->where('parent_id','0')
        //     ->where('lang',$lang)
        //     ->orderBy('order_id')->paginate(4);

        if(count($data) >0){
            return response()->json([
                "status"=>200,
                "data"=>$data,
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }

    }

    //get all category with sub category
    public function sub_category(Request $request)
    {
        $id = $request->input('id');
        $data = DB::select("SELECT categories.* FROM categories
            WHERE categories.parent_id =?",[$id]);

        if(count($data) >0){
            return response()->json([
                "status"=>200,
                "data"=>$data
            ]);
        }else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found"
            ]);
        }

    }



}

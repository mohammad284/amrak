<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\Service;
class AppSettingController extends Controller
{
    //get slider details
    public function get_slider(){
        $data = Slider::all();
        if(count($data)> 0){
            return response()->json([
                "status"=>200,
                "data"=>$data,
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }
    public function search(Request $request){
        if($request->cat_id == 0 ){
            $services = Service::where('name', 'Like', '%' . $request->name. '%')->get();

        }else{
            $services = Service::where('name', 'Like', '%' . $request->name. '%')->where('cat_id',$request->cat_id)->get();
        }
        $data = [];
        foreach($services as $service){
            $rate = ServiceReview::where('service_id',$service->id)->where('accept','1')->avg('rate');
            $category = Category::where('id',$service->cat_id)->first();
            $number_reviews = ServiceReview::where('service_id',$service->id)->where('accept','1')->count();
            $provider = Provider::where('id',$service->provider_id)->first();
            $provider_rate = ProviderReview::where('provider_id',$provider->id)->where('accept','1')->avg('rate');
            $final = array('service'=>$service,'number_reviews'=>$number_reviews,'provider_rate'=>$provider_rate,'rate'=>$rate ,'provider'=>$provider,'category__id'=>$category->id, 'category_name'=>$category->name, 'category__icon'=>$category->icon, 'category__font_color'=>$category->font_color, 'category__background_color'=>$category->background_color);
            array_push( $data ,$final);
        }
        return response()->json([
            "status"=>200,
            "data"=>$data,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AvailabilityHours;
use App\Models\Service;
use App\Models\ServiceReview;
use App\Models\UserFav;
use App\Models\User;
use App\Models\Category;
use App\Models\Provider;
use App\Models\ProviderReview;
use Carbon\Carbon;
//use Image;
//use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Image;

class ServicesController extends Controller
{
    //get all services

//    get details of a specific service
    public function service_detail(Request $request){
        // $serve = Service::where('id',$request->id)->first();
        // $provider = User::
        // return response()->json($serve);
        $id = $request->input('id');
        $user = $request->input('user_id');

        $data = DB::select("SELECT services.name AS servName, services.tax AS servTax,
        services.id AS servID,services.icon AS servIcon, services.discount AS servDisc,
        services.price AS servPrice, services.duration AS servDuration,services.hint AS servHint,
        services.description AS servDescription, services.available AS servAvailability, users.name AS providerName,
        users.icon AS provIcon, users.hint AS provHint, users.id AS provID, categories.name AS catName FROM services INNER JOIN users ON users.id=services.provider_id
        INNER JOIN categories ON categories.id=services.cat_id WHERE services.id =?",[$id]);
        $userFav =UserFav::where('user_id',$user)->get('service_id','user_id');
        
        $rateserv =ServiceReview::where('service_id',$id)->avg('rate');
        $count =ServiceReview::where('service_id',$id)->count();
        $available_hour = AvailabilityHours::where('service_id',$id)->with('service','day')->get();

        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "data"=>["data"=>$data,"is_favorite_to"=>$userFav,"rate_count"=>$count,"total_rate"=>$rateserv,"available hour"=>$available_hour]
            ]);
        }
        else{
            return  response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }
    //delete service by provider
    public function del_service(Request $request){
        $serv = $request->input('serv_id');
        $dat = Service::where('id',$serv)->update([
            'deleted_at'=>Carbon::now()
        ]);

        return response()->json([
            "status"=>200,
            "data"=>'delete successfully!'
        ]);
    }

    // add services by provider
    public function add_service_provider(Request $request){

        $data = json_decode($request->getContent());

        if($request->file('icon')){
            $image=$request->file('icon');
            $input['image'] = $image->getClientOriginalName();
            $path = 'images/services/';
            $destinationPath = 'images/services';
            $img = Image::make($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.time().$input['icon']);
            $name = $path.time().$input['icon'];
            
        $data['icon'] =  $name;
        }
        $service_data_ar = [
            'provider_id' => $request->input('provider_id'),
            'name' =>  $request->input('name_ar'),
            'cat_id'=>  $request->input('cat_id'),
            'duration'=>  $request->input('duration'),
            "description"=> $request->input('description_ar'),
            'discount'=> $request->input('discount'),
            'price_unit'=> $request->input('price_unit'),
            'price'=> $request->input('price'),
            'tax'=> $request->input('tax'),
            'available'=> $request->input('available'),
            'lang'=> 'ar',
            'icon'=>$data['icon'] 
        ];
        $service_ar = Service::create($service_data_ar);
        $service_data_en = [
            'provider_id' => $request->input('provider_id'),
            'name_en' =>  $request->input('name_en'),
            'cat_id'=>  $request->input('cat_id'),
            'duration'=>  $request->input('duration'),
            "description_ar"=> $request->input('description_en'),
            'discount'=> $request->input('discount'),
            'price_unit'=> $request->input('price_unit'),
            'price'=> $request->input('price'),
            'tax'=> $request->input('tax'),
            'available'=> $request->input('available'),
            'lang'=> 'en',
            'icon'=>$data['icon'] ,
            'ar_id'=> $service_ar->id
        ];
        $service_en = Service::create($service_data_en);

        return response()->json([
            "status" => 200,
            "message" => 'added successfully '
        ]);
    }
    public function update_service_provider(Request $request){
        $service = Service::find($request->id);
        if($service->ar_id == null){
            $service_ar = $service;
            $service_en = Service::where('ar_id',$service_ar->id)->first();
        }else{
            $service_en = $service;
            $service_ar = Service::where('id',$service_en->ar_id)->first();
        }
        if($request->file('icon')){
            $image=$request->file('icon');
            $input['image'] = $image->getClientOriginalName();
            $path = 'images/services/';
            $destinationPath = 'images/services';
            $img = Image::make($image->getRealPath());
            $img->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.time().$input['icon']);
            $name = $path.time().$input['icon'];
            
        $data['icon'] =  $name;
        }
        $service_data_ar = [
            'provider_id' => $request->input('provider_id'),
            'name' =>  $request->input('name_ar'),
            'cat_id'=>  $request->input('cat_id'),
            'duration'=>  $request->input('duration'),
            "description"=> $request->input('description_ar'),
            'discount'=> $request->input('discount'),
            'price_unit'=> $request->input('price_unit'),
            'price'=> $request->input('price'),
            'tax'=> $request->input('tax'),
            'available'=> $request->input('available'),
            'lang'=> 'ar',
            'icon'=>$data['icon'] 
        ];
        $service_data_en = [
            'provider_id' => $request->input('provider_id'),
            'name_en' =>  $request->input('name_en'),
            'cat_id'=>  $request->input('cat_id'),
            'duration'=>  $request->input('duration'),
            "description_ar"=> $request->input('description_en'),
            'discount'=> $request->input('discount'),
            'price_unit'=> $request->input('price_unit'),
            'price'=> $request->input('price'),
            'tax'=> $request->input('tax'),
            'available'=> $request->input('available'),
            'lang'=> 'en',
            'icon'=>$data['icon'] ,
            'ar_id'=> $service_ar->id
        ];
        $service_ar->update($service_data_ar);
        $service_en->update($service_data_en);
        return response()->json([
            "status" => 200,
            "message" => 'update successfully'
        ]);
    }
    public function delete_service_provider(){
        $service = Service::find($request->id);
        if($service->ar_id == null){
            $service_ar = $service;
            $service_en = Service::where('ar_id',$service_ar->id)->first();
        }else{
            $service_en = $service;
            $service_ar = Service::where('id',$service_en->ar_id)->first();
        }
        $service_en->delete();
        $service_ar->delete();
        return response()->json([
            "status" => 200,
            "message" => 'deleted successfully '
        ]);
    }
    // get services by provider
    public function get_service_provider(Request $request){
        $id = $request->input('id');
//        $pro = Service::where('provider_id',$id)->pluck('id');
        $data = DB::select("SELECT services.name AS servName,
                 services.tax AS Tax,services.icon AS servIcon,
                services.discount AS servDisc,services.price AS servPrice,
                services.available AS servState,services.duration AS servDuration,
                users.name AS providerName, users.icon AS Icon,categories.name AS catName
                FROM services
                INNER JOIN users ON users.id=services.provider_id
                INNER JOIN categories ON categories.id=services.cat_id
                WHERE services.provider_id =?",[$id]);

        $count =ServiceReview::where('id',$id)->count();
        $rateserv =ServiceReview::where('id',$id)->avg('rate');
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "message"=>["data"=>$data,"rate_count"=>$count,"total_rate"=>$rateserv]
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }
    // get services by category
    public function get_service_category(Request $request){
        $id = $request->input('cat_id');

        $category = Category::where('id',$id)->first();
        $services = Service::where('cat_id',$id)->get();
        

        if($category->parent_id != 0){
            $sub_cat = Category::where('id',$category->parent_id)->first();
            $data = [];

            foreach($services as $service){
                $rate = ServiceReview::where('service_id',$service->id)->where('accept','1')->avg('rate');
                $number_reviews = ServiceReview::where('service_id',$service->id)->where('accept','1')->count();
                $provider = User::where('id',$service->provider_id)->first();
                $provider_rate = ProviderReview::where('provider_id',$provider->id)->where('accept','1')->avg('rate');
                $final = array('service'=>$service,'number_reviews'=>$number_reviews,'provider_rate'=>$provider_rate,'rate'=>$rate ,'provider'=>$provider,'category__id'=>$category->id, 'category_name'=>$category->name, 'category__icon'=>$category->icon, 'category__font_color'=>$category->font_color, 'category__background_color'=>$category->background_color,'sub__id'=>$sub_cat->id, 'sub_name'=>$sub_cat->name, 'sub__icon'=>$sub_cat->icon, 'sub__font_color'=>$sub_cat->font_color, 'sub__background_color'=>$sub_cat->background_color);
                array_push( $data ,$final);
            }
        }else{
        
            $data = [];
            foreach($services as $service){
                $rate = ServiceReview::where('service_id',$service->id)->where('accept','1')->avg('rate');
                $number_reviews = ServiceReview::where('service_id',$service->id)->where('accept','1')->count();

                $provider = User::where('id',$service->provider_id)->first();

                $provider_rate = ProviderReview::where('provider_id',$provider->id)->where('accept','1')->avg('rate');
                $final = array('number_reviews'=>$number_reviews,'provider_rate'=>$provider_rate,'rate'=>$rate ,'service'=>$service ,'provider'=>$provider,'category__id'=>$category->id, 'category_name'=>$category->name, 'category__icon'=>$category->icon, 'category__font_color'=>$category->font_color, 'category__background_color'=>$category->background_color,'sub__id'=>null, 'sub_name'=>null, 'sub__icon'=>null, 'sub__font_color'=>null, 'sub__background_color'=>null);
                array_push( $data ,$final);
            }
        }

        // $userFav =UserFav::where('user_id',$user)->get('service_id','user_id');
        $count =ServiceReview::where('service_id',$id)->count();
        $rateserv =ServiceReview::where('service_id',$id)->avg('rate');
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "message"=>["data"=>$data,"rate_count"=>$count,"total_rate"=>$rateserv]
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }

    //add service to favorite
    public function add_user_fav(Request $request){

        $service_id = $request->input('service_id');
        $user_id = $request->input('user_id');
//        $data = json_decode($request->getContent());
        $fav = UserFav::create([
                'user_id' => $user_id,
                'service_id' => $service_id,
            ]);


        return response()->json([
            "status"=>200,
            "message"=>$fav,
        ]);
    }

    public function del_user_fav(Request $request){
        $serv =$request->input('serv_id');
        $user =$request->input('user_id');
        $dat = UserFav::where('user_id',$user)->where('service_id',$serv)->delete();
        return response()->json([
            "status"=>200,
            "message"=>"delete successfully"
        ]);
    }

    public function get_user_fav(Request $request){
        $id = $request->input('id');

        $servies = UserFav::where('user_id',$request->id)->get();
        $service_details = [];
        foreach($servies as $servie){
            $provider = User::where('id',$servie->user_id)->first();
            $service = Service::where('id',$servie->service_id)->first();
            $final = array('provider'=>$provider,'service'=>$service);
            array_push($service_details,$final);
        }

        if(count($service_details)>0){
            return response()->json([
               "status" =>200 ,
               "data" => $service_details,
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }

    //get service featured
    public function get_feature(Request $request){

        $lang = $request->input('lang');
        $data = Service::where('featured_id',1)->where('lang',$lang)->with('providers','categories')->paginate(2);

        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "message"=>$data,
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }

    //get availability hours for a services
    public function get_service_hours(Request $request){
        $id = $request->input('id');


            $data = DB::select("SELECT availability_hours.start_at,
            availability_hours.end_at,services.name as service,days.name as day FROM availability_hours
            INNER JOIN days ON days.id = availability_hours.day_id
            INNER JOIN services ON services.id = availability_hours.service_id
            WHERE availability_hours.service_id=? ",[$id]);

        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "message"=>$data,
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }

    }
    //get all review on a service
    public function get_review_service(Request $request){
        $id = $request->input('id');
        $reviews = ServiceReview::where('service_id',$id)->get();
        $review_details = [];
        foreach($reviews as $review){
            $customer = User::where('id',$review->customer_id)->first();
            $final = array('review'=>$review,'customer'=>$customer);
            array_push($review_details,$final);
        }
        if (count($review_details)>0){
            return response()->json([
                "status"=>200,
                "message"=>$review_details
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }

    }

    //add rate and review for a service
    public function add_review_service(Request $request){
        $service_id = $request->input('service_id');
        $customer_id = $request->input('customer_id');
        $rate = $request->input('rate');
        $review = $request->input('review');

        $data= ServiceReview::create([
            'service_id' => $service_id,
            'customer_id' => $customer_id,
            'rate' => $rate,
            'review' => $review
        ]);
        $avg_rate = ServiceReview::where('service_id',$service_id)->avg('rate');
        $service_rate = Service::find($service_id);
        $service_rate->rate = $avg_rate ;
        $service_rate->save();

        return response()->json([
            "status"=>200,
            "message"=>$data,
        ]);
    }
    public function topRate(Request $request){
        $services = Service::orderBy('rate','DESC')->where('lang',$request->lang)->take(5)->get();
        $data = [];
        foreach($services as $service){
            $rate = ServiceReview::where('service_id',$service->id)->where('accept','1')->avg('rate');
            $category = Category::where('id',$service->cat_id)->first();
            $number_reviews = ServiceReview::where('service_id',$service->id)->where('accept','1')->count();
            $provider = User::where('id',$service->provider_id)->first();
            $provider_rate = ProviderReview::where('provider_id',$provider->id)->where('accept','1')->avg('rate');
            $final = array('service'=>$service,'number_reviews'=>$number_reviews,'provider_rate'=>$provider_rate,'rate'=>$rate ,'provider'=>$provider,'category__id'=>$category->id, 'category_name'=>$category->name, 'category__icon'=>$category->icon, 'category__font_color'=>$category->font_color, 'category__background_color'=>$category->background_color);
            array_push( $data ,$final);
        }
        return response()->json([
            "status"=>200,
            "message"=>$data,
        ]);
    }
    public function requmented(Request $request){
        $services = Service::orderBy('number_of_reserv','DESC')->where('lang',$request->lang)->take(5)->get();
        $data = [];
        foreach($services as $service){
            $rate = ServiceReview::where('service_id',$service->id)->where('accept','1')->avg('rate');
            $category = Category::where('id',$service->cat_id)->first();
            $number_reviews = ServiceReview::where('service_id',$service->id)->where('accept','1')->count();
            $provider = User::where('id',$service->provider_id)->first();
            $provider_rate = ProviderReview::where('provider_id',$provider->id)->where('accept','1')->avg('rate');
            $final = array('service'=>$service,'number_reviews'=>$number_reviews,'provider_rate'=>$provider_rate,'rate'=>$rate ,'provider'=>$provider,'category__id'=>$category->id, 'category_name'=>$category->name, 'category__icon'=>$category->icon, 'category__font_color'=>$category->font_color, 'category__background_color'=>$category->background_color);
            array_push( $data ,$final);
        }
        return response()->json([
            "status"=>200,
            "message"=>$data,
        ]);
    }

}

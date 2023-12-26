<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConditionRoles;
use App\Models\Language;
use App\Models\TermsPrivacy;
use Illuminate\Http\Request;

class TermsPrivacyController extends Controller
{
    // get terms for app
    public function  get_terms(Request $request){

        $lang = $request->input('lang');
        $data = TermsPrivacy::where('lang',$lang)->get(['title','content']);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "message"=>$data
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }

    // get roles for app
    public function  get_roles(Request $request){

        $lang = $request->input('lang');
        $data = ConditionRoles::where('lang',$lang)->get(['title','content']);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "message"=>$data
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }

    // get notifications for app
    public function  get_lang(){

        $data = Language::get(['code','name']);
        if (count($data)>0){
            return response()->json([
                "status"=>200,
                "message"=>$data
            ]);
        }
        else{
            return response()->json([
                "status"=>404,
                "message"=>"Not Found",
            ]);
        }
    }
}

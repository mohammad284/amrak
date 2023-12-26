<?php
/**
 * Created by PhpStorm.
 * User: Alos
 * Date: 12/8/2021
 * Time: 11:42 AM
 */
namespace App\Traits;


trait Helper
{
    public function destroyController($model, $id)
    {

        $item = $model::findorFail($id);
        if ($item) {

            $item->delete();
        }
        return response()->json(['status' => 200, 'success' => 'تم الحذف بنجاح']);
    }

    public function editController($model, $id)
    {

        $item = $model::findorFail($id);
        return response()->json($item);
    }

    public function accept($request,$id,$model){
        $model::find($id)->update(['accept'=>$request->accept]);
        return response()->json(['success'=>' تمت العملية بنجاح ']);
    }
}

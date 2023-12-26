<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable=[
        'email','accept','icon','password','name','hint','mobile','address','availability_rang','available','phone','description'
    ];



    protected static function boot(){
        parent::boot();
        static ::deleted(function ($model){
            Service::where('provider_id',$model->id)->delete();
        });

    }
    protected $hidden = [
        'password',
        'remember_token',
    ];
}

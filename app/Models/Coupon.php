<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable =
        [
//discount_type -> 0 percent,1-> amount
            'code','discount','service_id','discount_type','is_used','user_id','enable'
        ];
    protected $casts = [
        'created_at' => 'datetime:Y/m/d',
//        'expire_at' => 'datetime:Y/m/d'
    ];
    public function user(){
        return $this->hasMany(User::class,'id','user_id');
    }

    public function service(){
        return $this->belongsTo('App\Models\Service' , 'service_id','id');
    }

}

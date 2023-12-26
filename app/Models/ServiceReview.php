<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceReview extends Model
{
    use HasFactory;

//    protected $appends = ['stars_average'];

    protected $fillable =
        [
            'service_id','customer_id','review','rate','accept'
        ];
    public function services(){
        return $this->belongsTo('App\Models\Service' , 'service_id','id');
    }
    public function customer(){
        return $this->belongsTo('App\Models\User' , 'customer_id','id');
    }
//    public function getStarsAverageAttribute(){
//        return $this->rate()->average('rate');
//    }
}

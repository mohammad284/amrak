<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailabilityHours extends Model
{
    use HasFactory;
    protected $fillable =
        [
            'service_id','day_id','start_at','end_at'
        ];
    public function service(){
        return $this->belongsTo('App\Models\Service' , 'service_id','id');
    }
    public function day(){
        return $this->belongsTo('App\Models\Day' , 'day_id','id');
    }


}

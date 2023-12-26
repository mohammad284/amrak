<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderWorkHour extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'day_id', 'provider_id','details','start_at','end_at'
        ];
    public function providers(){
        return $this->belongsTo('App\Models\User' , 'provider_id','id');
    }
    public function day(){
        return $this->belongsTo('App\Models\Day' , 'day_id','id');
    }
}


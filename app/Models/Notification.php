<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected  $fillable =
        [
            'booking_id','title','notify_type','user_id','provider_id','content','unsent'
        ];
    protected $casts =
        [
            'created_at' => 'datetime:Y/m/d'
        ];
    public function user(){
        return $this->hasMany(User::class,'user_id','id');
    }
    public function provider(){
        return $this->hasMany(User::class,'provider_id','id');
    }
    public function booking(){
        return $this->hasMany(Booking::class,'booking_id','id');
    }
}

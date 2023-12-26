<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable =
        [
            //'booking_at' => created_at
          'service_id','customer_id','provider_id','count','hint','book_date',
            'address','booking_state_id','payment_state_id','coupon_id','total','accept','address_user','lan','lat'
        ];

    public function customer(){
        return $this->belongsTo('App\Models\User' , 'customer_id','id');
    }
    public function service(){
        return $this->belongsTo('App\Models\Service' , 'service_id','id');
    }
    public function provider(){
        return $this->belongsTo('App\Models\User' , 'provider_id','id');
    }
    public function booking_state(){
        return $this->belongsTo('App\Models\BookingState' , 'booking_state_id','id');
    }
    public function payment_state(){
        return $this->belongsTo('App\Models\PaymentState' , 'payment_state_id','id');
    }

}

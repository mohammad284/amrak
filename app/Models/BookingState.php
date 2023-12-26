<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingState extends Model
{
    use HasFactory;
    protected $fillable =
        [
            //SELECT * FROM `booking_states` WHERE lang = 'ar'
            'name','trans_id','lang'
        ];
    public function trans(){
        return $this->belongsTo(BookingState::class, 'trans_id','id');
    }
}

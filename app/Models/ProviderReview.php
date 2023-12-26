<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderReview extends Model
{
    use HasFactory;
    protected $fillable =
        [
           'customer_id', 'provider_id','comment','rate','accept'
        ];
    public function provider(){
        return $this->belongsTo('App\Models\User' , 'provider_id','id');
    }
    public function customer(){
        return $this->belongsTo('App\Models\User' , 'customer_id','id');
    }
}

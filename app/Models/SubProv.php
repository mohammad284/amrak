<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProv extends Model
{
    use HasFactory;
    protected $fillable =
        [
          'provider_id','subscript_id'
        ];
    public function providers(){
        return $this->belongsTo(User::class , 'provider_id','id');
    }
    public function subscripts(){
        return $this->belongsTo(Subscriptions::class , 'subscript_id','id');
    }

}

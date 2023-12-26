<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookNotify extends Model
{
    use HasFactory;
    protected $table = "notifications";
    protected $fillable = [
            'user_id','provider_id','title','details', 'unset'
        ];
    public function customer(){
        return $this->belongsTo('App\Models\User' , 'user_id','id');
    }
    public function provider(){
        return $this->belongsTo('App\Models\User' , 'provider_id','id');
    }

}

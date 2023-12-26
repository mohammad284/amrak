<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserFav extends Model
{
    use HasFactory;
    protected $fillable =
        [
            'user_id','service_id'
        ];
    public function service(){
        return $this->belongsTo(Service::class, 'service_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id','id');
    }
}

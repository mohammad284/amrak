<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCopone extends Model
{
    use HasFactory;
    protected $fillable = ['service_id','user_id','coupon'];
}

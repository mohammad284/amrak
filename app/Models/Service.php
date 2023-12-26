<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Provider;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name','icon','provider_id','cat_id','duration','hint','description',
        'discount','price_unit','price','tax','available','featured_id','lang','number_of_reserv','ar_id'
    ];

    public function providers(){
        return $this->belongsTo(User::class, 'provider_id','id');
    }
    public function categories(){
        return $this->belongsTo(Category::class, 'cat_id','id');
    }


}

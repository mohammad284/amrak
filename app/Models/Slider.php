<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    //enable -> yes, no
//    image_service ->
    protected $fillable =
        [
            'text','btn','text_color','btn_color','background_color','indicator_color','image_service','enable'
        ];
    public function btn(){
        return $this->hasMany(Color::class,'id','btn_color');
    }
    public function background(){
        return $this->hasMany(Color::class,'id','background_color');
    }
    public function text(){
        return $this->hasMany(Color::class,'id','text_color');
    }
    public function indecatore(){
        return $this->hasMany(Color::class,'id','indicator_color');
    }
}

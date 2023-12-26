<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class Category extends Model
{
    use HasFactory;
    protected $fillable =
         [
           'name','order_id','color_id','lang','trans_id','icon','parent_id','background_color','font_color','featured','ar_id'
         ];

    //parent_id = 0 -> category
    //parent_id = integer -> sub category
    //childs() : return list of Category Childs
    //trans_id -> cat.id to translate it simply

    public function childs() {
        return $this->hasMany(Category::class, 'parent_id','id');
    }

    public function color(){
        return $this->hasMany(Color::class,'id','color_id');
    }
    public function background(){
        return $this->hasMany(Color::class,'id','background_color');
    }
    public function font(){
        return $this->hasMany(Color::class,'id','font_color');
    }
    public function trans(){
        return $this->belongsTo(Category::class , 'trans_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Self_;

class PaymentState extends Model
{
    use HasFactory;
    protected $fillable =[
        'name','lang','trans_id'
    ];
    public function trans(){
        return $this->belongsTo(Self_::class , 'trans_id','id');
    }

}

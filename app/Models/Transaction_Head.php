<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_Head extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second';

    protected $guarded = [];
    public $timestamps = false;

    public function Groupe(){
        return $this->belongsTo(Transaction_Groupe::class,'groupe_id','id');
    }
    public function Category(){
        return $this->belongsTo(Item_Category::class,'category_id','id');
    }
    public function Manufecturer(){
        return $this->belongsTo(Item_Manufacturer::class,'manufacturer_id','id');
    }
    public function Form(){
        return $this->belongsTo(Item_Form::class,'form_id','id');
    }
    public function Unit(){
        return $this->belongsTo(Item_Unit::class,'unit_id','id');
    }
    public function Store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }
}

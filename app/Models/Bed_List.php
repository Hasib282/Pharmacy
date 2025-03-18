<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed_List extends Model
{
    protected $connection = 'mysql_second';

    protected $guarded = [];

    public $timestamps = false;

    public function category(){
        return $this->belongsTo(Bed_Category::class,'category','id');
    }

    public function nursing(){
        return $this->belongsTo(Nursing_Station::class,'nursing_station','id');
    }
}

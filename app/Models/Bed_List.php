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

    public function floor(){
        return $this->belongsTo(Floor::class,'floor','id');
    }
    
    public function Booking(){
        return $this->hasMany(Booking::class,'bed_list','id');
    }

    public function latestBooking(){
        return $this->hasOne(Booking::class, 'bed_list', 'id')->latestOfMany();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;

    public function Location(){
        return $this->belongsTo(Location_Info::class,'location_id','id');
    }
}

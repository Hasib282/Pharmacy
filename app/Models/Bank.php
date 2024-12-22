<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;

    public function Location(){
        return $this->belongsTo(Location_Info::class,'loc_id','id');
    }
}

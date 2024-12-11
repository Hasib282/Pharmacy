<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;

    public function Location(){
        return $this->belongsTo(Location_Info::class,'location_id','id');
    }
}

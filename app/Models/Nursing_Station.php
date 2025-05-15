<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nursing_Station extends Model
{
    protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;

    public function Floor(){
        return $this->belongsTo(Floor::class,'floor','id');
    }
}

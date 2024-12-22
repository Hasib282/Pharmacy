<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendence extends Model
{
    protected $connection = 'mysql_second';
    
    protected $guarded = [];

    public $timestamps = false;

    public function employee(){
        return $this->belongsTo(User_Info::class,'employee_id','id');
    }
}

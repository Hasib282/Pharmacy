<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appoinment extends Model
{
    use HasFactory;
    protected  $connection = 'mysql_second';
    protected $guarded  =  [];
    public $timestamps = false;

    public function Doctor(){
        return $this->belongsTo(Doctor_Information::class,'Doctor','id');
    } 

    public function Patient(){
        return $this->belongsTo(Patient_Information::class,'ptn_id','ptn_id');
    }
}

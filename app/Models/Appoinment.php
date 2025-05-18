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

    public function User(){
        return $this->belongsTo(User_Info::class,'user_id','user_id');
    }
}

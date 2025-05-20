<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;

    public function User(){
        return $this->belongsTo(User_info::class,'user_id','user_id');
    }
    
    public function Sr(){
        return $this->belongsTo(User_info::class,'sr_id','user_id');
    }

    public function Category(){
        return $this->belongsTo(Bed_Category::class,'bed_category','id');
    }

    public function List(){
        return $this->belongsTo(Bed_List::class,'bed_list','id');
    }

    public function Doctors(){
        return $this->belongsTo(Doctor_Information::class,'doctor','id');
    }
    
    public function Bill(){
        return $this->belongsTo(Transaction_Main::class,'tran_id','tran_id');
    }
}

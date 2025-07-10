<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction_Main extends Model
{
    protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;

    public function Bank(){
        return $this->belongsTo(Bank::class,'tran_user','user_id');
    }
    
    public function User(){
        return $this->belongsTo(User_Info::class,'tran_user','user_id');
    }

    public function getTranNameAttribute()
    {
        if ($this->tran_type == 4) {
            return $this->bank?->name;
        }

        return $this->user?->user_name;
    }

    public function Location(){
        return $this->belongsTo(Location_Info::class,'loc_id','id');
    }

    public function Withs(){
        return $this->belongsTo(Transaction_With::class,'tran_type_with','id');
    }

    public function Store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }


    public function Type(){
        return $this->belongsTo(Transaction_Main_Head::class,'tran_type','id');
    }
}

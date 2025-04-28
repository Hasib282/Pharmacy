<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction_Detail extends Model
{
    protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;

    public function Bank(){
        return $this->belongsTo(Bank::class,'tran_bank','user_id');
    }
    
    public function User(){
        return $this->belongsTo(User_Info::class,'tran_user','user_id');
    }
    
    public function Patient(){
        return $this->belongsTo(Patient_Information::class,'ptn_id','ptn_id');
    }

    public function Head(){
        return $this->belongsTo(Transaction_Head::class,'tran_head_id','id');
    }


    public function Groupe(){
        return $this->belongsTo(Transaction_Groupe::class,'tran_groupe_id','id');
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

    public function Unit(){
        return $this->belongsTo(Item_Unit::class,'unit_id','id');
    }

    public function Type(){
        return $this->belongsTo(Transaction_Main_Head::class,'tran_type','id');
    }
}

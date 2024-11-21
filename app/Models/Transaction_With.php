<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_With extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function role(){
        return $this->belongsTo(Role::class,'user_role','id');
    }

    public function Type(){
        return $this->belongsTo(Transaction_Main_Head::class,'tran_type','id');
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction_Groupe extends Model
{
    protected $connection = 'mysql_second';

    protected $guarded = [];
    public $timestamps = false;

    public function Type(){
        return $this->belongsTo(Transaction_Main_Head::class,'tran_groupe_type','id');
    }
}

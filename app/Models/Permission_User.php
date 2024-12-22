<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission_User extends Model
{
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;


    public function user(){
        return $this->belongsTo(User_Info::class,'user_id','user_id');
    }

    public function permission(){
        return $this->belongsTo(Permission_Head::class);
    }
}

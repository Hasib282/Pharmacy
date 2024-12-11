<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_User extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;


    public function user(){
        return $this->belongsTo(User_Info::class,'user_id','user_id');
    }

    public function permission(){
        return $this->belongsTo(Permission_Head::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission_Role extends Model
{
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;


    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function permission(){
        return $this->belongsTo(Permission_Head::class);
    }
}

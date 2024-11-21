<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_Head extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function mainhead(){
        return $this->belongsTo(Permission_Main_Head::class, 'permission_mainhead', 'id');
    }
    
    public function roles(){
        return $this->belongsToMany(Role::class, 'permission__roles', 'permission_id', 'role_id');
    }


    public function routes()
    {
        return $this->hasMany(Permission_Route::class, 'permission_id', 'id');
    }


    public function users(){
        return $this->belongsToMany(User_Info::class, 'permission__users', 'permission_id', 'user_id', 'id', 'user_id');
    }

}

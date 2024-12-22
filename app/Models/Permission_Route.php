<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission_Route extends Model
{
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;

    public function permission(){
        return $this->belongsTo(Permission_Head::class, 'permission_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission_Route extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;

    public function permission(){
        return $this->belongsTo(Permission_Head::class, 'permission_id', 'id');
    }
}

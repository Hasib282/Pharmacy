<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission_Company_Type extends Model
{
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;

    public function type(){
        return $this->belongsTo(Company_Type::class);
    }

    public function permission(){
        return $this->belongsTo(Permission_Head::class);
    }
}

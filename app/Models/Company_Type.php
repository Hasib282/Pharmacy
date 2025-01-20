<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company_Type extends Model
{
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;

    public function permissions(){
        return $this->belongsToMany(Permission_Head::class, 'permission__company__types', 'company_type_id', 'permission_id', 'id', 'id');
    }
}

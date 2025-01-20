<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company_Details extends Model
{
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;
    

    public function Type(){
        return $this->belongsTo(Company_Type::class,'company_type','id');
    }

    // Creating many to many relationship with permission table by creating a pivot table connection
    public function permissions(){
        return $this->belongsToMany(Permission_Head::class, 'permission__companies', 'company_id', 'permission_id', 'company_id', 'id');
    }
}

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
}

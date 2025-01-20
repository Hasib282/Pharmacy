<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission_Company extends Model
{
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;


    public function company(){
        return $this->belongsTo(Company_Details::class,'company_id','company_id');
    }

    public function permission(){
        return $this->belongsTo(Permission_Head::class);
    }
}

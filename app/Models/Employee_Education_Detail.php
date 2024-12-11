<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee_Education_Detail extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    
    protected $guarded = [];
    
    public function User(){
        return $this->belongsTo(User_Info::class,'emp_id','user_id');
    }

    public function personalDetail()
    {
        return $this->belongsTo(Employee_Personal_Detail::class, 'emp_id', 'employee_id');
    }

}

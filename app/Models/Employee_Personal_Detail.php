<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee_Personal_Detail extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function educationDetail()
    {
        return $this->belongsTo(Employee_Education_Detail::class, 'employee_id', 'emp_id');
    }

    public function trainingDetail()
    {
        return $this->belongsTo(Employee_Training_Detail::class, 'employee_id', 'emp_id');
    }

    public function experienceDetail()
    {
        return $this->belongsTo(Employee_Experience_Detail::class, 'employee_id', 'emp_id');
    }

    public function organizationDetail()
    {
        return $this->belongsTo(Employee_Organization_Detail::class, 'employee_id', 'emp_id');
    }

    public function Location(){
        return $this->belongsTo(Location_Info::class,'location_id','id');
    }

    public function Withs(){
        return $this->belongsTo(Transaction_With::class,'tran_user_type','id');
    }

}

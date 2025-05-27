<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class User_Info extends Model
{
    use Notifiable;

    protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;

    protected $table = 'user__infos';

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function Roles(){
        return $this->belongsTo(Role::class,'user_role','id');
    }
    
    public function Company(){
        return $this->belongsTo(Company_Details::class,'company_id','company_id');
    }
    
    public function Store(){
        return $this->belongsTo(Store::class,'store_id','id');
    }

    public function Department(){
        return $this->belongsTo(Department::class,'dept_id','id');
    }

    public function Location(){
        return $this->belongsTo(Location_Info::class,'loc_id','id');
    }

    public function Designation(){
        return $this->belongsTo(Designation::class,'designation_id','id');
    }


    public function Withs(){
        return $this->belongsTo(Transaction_With::class,'tran_user_type','id');
    
    }

    public function personalDetail()
    {
        return $this->belongsTo(Employee_Personal_Detail::class, 'user_id', 'employee_id');
    }

    public function educationDetail()
    {
        return $this->belongsTo(Employee_Education_Detail::class, 'user_id', 'emp_id');
    }

    public function educationDetails()
    {
        return $this->hasMany(Employee_Education_Detail::class);
    }


    public function trainingDetail()
    {
        return $this->belongsTo(Employee_Training_Detail::class, 'user_id', 'emp_id');
    }

    public function experienceDetail()
    {
        return $this->belongsTo(Employee_Experience_Detail::class, 'user_id', 'emp_id');
    }

    public function organizationDetail()
    {
        return $this->belongsTo(Employee_Organization_Detail::class, 'user_id', 'emp_id');
    }

    ///// client base due find for user_type User_Info Table /////////
    
    public function transaction()
    {
        return $this->hasMany(Transaction_Main::class, 'tran_user', 'user_id');
    }


    // Creating many to many relationship with permission table by creating a pivot table connection
    public function permissions(){
        return $this->belongsToMany(Permission_Head::class, 'permission__users', 'user_id', 'permission_id', 'login_user_id', 'id');
    }

    
    public function role(){
        return $this->hasOne(Role::class, 'id', 'user_role');
    }

    public function latestBooking(){
        return $this->hasOne(Booking::class, 'user_id', 'user_id')->latestOfMany();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed_Transfer extends Model
{
    use HasFactory;

    protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;

    public function FromList(){
        return $this->belongsTo(Bed_List::class,'from_bed','id');
    }
    
    public function ToList(){
        return $this->belongsTo(Bed_List::class,'to_bed','id');
    }

    public function User(){
        return $this->belongsTo(User_info::class,'user_id','user_id');
    }
}

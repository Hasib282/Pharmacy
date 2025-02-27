<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor_Information extends Model
{
   protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;
}

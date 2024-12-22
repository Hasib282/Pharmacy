<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission_Company extends Model
{
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;
}

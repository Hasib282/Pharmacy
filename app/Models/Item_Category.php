<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_Category extends Model
{
    protected $connection = 'mysql_second';

    protected $guarded = [];
    
    public $timestamps = false;
}

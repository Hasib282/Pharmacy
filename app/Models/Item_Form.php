<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_Form extends Model
{
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;
}

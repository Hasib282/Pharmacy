<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_Method extends Model
{
    
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;
}

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
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location_Info extends Model
{
    // use HasFactory;
    protected $connection = 'mysql';

    protected $guarded = [];
    
    public $timestamps = false;
}

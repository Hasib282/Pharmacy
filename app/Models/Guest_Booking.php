<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest_Booking extends Model
{
    use HasFactory;
    protected $connection = 'mysql_second';

    protected $guarded = [];

    public $timestamps = false;
}

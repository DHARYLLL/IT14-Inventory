<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
    protected $table = 'vehicles';
    protected $fillable = [
        'veh_name',
        'veh_brand',
        'veh_plate_no'
    ];
}

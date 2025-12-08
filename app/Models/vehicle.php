<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vehicle extends Model
{
    protected $table = 'vehicles';
    protected $fillable = [
        'driver_name',
        'driver_contact_number',
        'veh_price'
    ];
}

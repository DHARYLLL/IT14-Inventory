<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class embalming extends Model
{
    protected $table = 'embalming';
    protected $fillable = [
        'emblamer_name',
        'unit_price'
    ];
}

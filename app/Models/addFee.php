<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class addFee extends Model
{
    protected $table = 'add_fees';
    protected $fillable = [
        'fee_name',
        'fee_amount',
        'jo_id'
    ];
}

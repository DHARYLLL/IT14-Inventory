<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stockOut extends Model
{
    protected $table = 'stock_outs';
    protected $fillable = [
        'reason',
        'so_qty',
        'so_date',
        'stock_id',
        'eq_id',
        'emp_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class addStock extends Model
{
    protected $table = 'add_stock';
    protected $fillable = [
        'pkg_id',
        'stock_id',
        'stock_dpl'
    ];
}

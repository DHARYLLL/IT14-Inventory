<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChapStock extends Model
{
    protected $table = 'chapel_stocks';
    protected $fillable = [
        'chap_id',
        'stock_id',
        'stock_used'
    ];
}

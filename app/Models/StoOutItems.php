<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoOutItems extends Model
{
    protected $table = 'sto_out_items';
    protected $fillable = [
        'so_id',
        'stock_id',
        'so_qty'
    ];

    public function soiToSto () {
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}

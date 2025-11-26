<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class addStock extends Model
{
    protected $table = 'add_stock';
    protected $fillable = [
        'jod_id',
        'stock_id',
        'stock_dpl',
        'stock_add_fee'
    ];

    public function addStoToSto(){
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}

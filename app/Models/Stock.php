<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $fillable = [
        'item_name',
        'item_qty',
        'size_weight',
        'item_unit_price'
    ];

    public function stoToSvcSto(){
        return $this->hasMany(SvsStock::class, 'stock_id');
    }
}

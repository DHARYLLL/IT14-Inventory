<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';
    protected $fillable = [
        'item_name',
        'item_qty',
        'item_size',
        'item_unit',
        'item_unit_price',
        'item_type'
    ];

    public function stoToSvcSto(){
        return $this->hasMany(SvsStock::class, 'stock_id');
    }

    public function stoToPkgSto(){
        return $this->belongsTo(PkgStock::class, 'stock_id');
    }
}

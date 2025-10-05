<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'supplier'
    ];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}

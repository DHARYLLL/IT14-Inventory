<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $table = 'purchase_order_items';
    protected $fillable = [
        'item',
        'qty',
        'sizeWeight',
        'unit_price',
        'total_amount',
        'qty_arrived',
        'po_id',
        'stock_id'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}

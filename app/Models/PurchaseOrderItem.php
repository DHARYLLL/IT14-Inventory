<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $table = 'purchase_order_items';
    protected $fillable = [
        'item',
        'size',
        'qty',
        'qty_set',
        'qty_total',
        'unit_price',
        'total_amount',
        'qty_arrived',
        'type',
        'po_id',
        'stock_id',
        'eq_id'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }
}

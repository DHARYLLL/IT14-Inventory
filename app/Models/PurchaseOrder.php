<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_orders';
    protected $fillable = [
        'status',
        'total_amount',
        'submitted_date',
        'approved_date',
        'delivered_date',
        'supplier_id',
        'emp_id',
        'archived'
    ];

    public function poToSup()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function poToEmp()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public function poToInv()
    {
        return $this->hasOne(Invoice::class, 'po_id');
    }
}

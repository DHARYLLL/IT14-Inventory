<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'total',
        'po_id'
    ];

    public function invToPo(){
        return $this->belongsTo(PurchaseOrder::class, 'po_id');
    }
}

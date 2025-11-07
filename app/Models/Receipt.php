<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $table = 'receipts';
    protected $fillable = [
        'client_name',
        'client_contact_number',
        'rcpt_status',
        'payment_amount',
        'emp_id',
        'svc_id'
    ];

}

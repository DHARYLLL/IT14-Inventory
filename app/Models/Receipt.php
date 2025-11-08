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
        'paid_amount',
        'total_payment',
        'emp_id',
        'svc_id'
    ];

    public function rcptToSvcReq() {
        return $this->belongsTo(ServiceRequest::class, 'svc_id');
    }

    public function rcptToEmp() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }


}

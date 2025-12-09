<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jobOrder extends Model
{
    protected $table = 'job_orders';
    protected $fillable = [
        'client_name',
        'client_contact_number',
        'client_address',
        'ra',
        'jo_dp',
        'jo_total',
        'jo_status',
        'jo_start_date',
        'jo_embalm_time',
        'jo_burial_date',
        'jo_burial_time',
        'emp_id',
        'jod_id',
        'svc_id',
        'ba_id'
    ];

    public function joToEmp(){
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public function joToJod(){
        return $this->belongsTo(jobOrderDetails::class, 'jod_id');
    }

    public function joToSvcReq(){
        return $this->belongsTo(ServiceRequest::class, 'svc_id');
    }

    public function joToBurAsst(){
        return $this->belongsTo(BurialAssistance::class, 'ba_id');
    }
}

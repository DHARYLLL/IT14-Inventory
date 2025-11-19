<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jobOrder extends Model
{
    protected $table = 'job_orders';
    protected $fillable = [
        'client_name',
        'client_contact_number',
        'jo_dp',
        'jo_total',
        'jo_status',
        'emp_id',
        'jod_id',
        'svc_id'

    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $table = 'services_requests';
    protected $fillable = [
        'svc_startDate',
        'svc_endDate',
        'svc_wakeLoc',
        'svc_churchLoc',
        'svc_burialLoc',
        'svc_equipment_status',
        'package_id',
        'emp_id'
    ];

    public function svcReqToPac() {
        return $this->belongsTo(Package::class, 'package_id');
    }

}

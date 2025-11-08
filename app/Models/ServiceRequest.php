<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $table = 'services_requests';
    protected $fillable = [
        'dec_name',
        'dec_born_date',
        'dec_died_date',
        'dec_cause_of_death',
        'dec_mom_name',
        'dec_fr_name',
        'svc_startDate',
        'svc_endDate',
        'svc_wakeLoc',
        'svc_churchLoc',
        'svc_burialLoc',
        'svc_equipment_status',
        'svc_deploy_date',
        'svc_return_date',
        'pkg_id',
        'chap_id'
    ];

    public function svcReqToPac() {
        return $this->belongsTo(Package::class, 'pkg_id');
    }

    public function svcReqToRcpt() {
        return $this->hasOne(Receipt::class, 'svc_id');
    }

}

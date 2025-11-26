<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $table = 'services_requests';
    protected $fillable = [
        'svc_name',
        'svc_amount',
        'veh_id',
        'prep_id'
    ];


    public function svcReqToEmbalm() {
        return $this->belongsTo(embalming::class, 'prep_id');
    }

    public function svcReqToVeh() {
        return $this->belongsTo(vehicle::class, 'veh_id');
    }

}

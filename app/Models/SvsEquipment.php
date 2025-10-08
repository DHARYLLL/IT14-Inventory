<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SvsEquipment extends Model
{
    protected $table = 'svs_equipments';
    protected $fillable = [
        'service_id',
        'equipment_id',
        'eq_used'
    ];

    public function svcEqToEq(){
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function svcEqToSvcReq(){
        return $this->belongsTo(ServiceRequest::class, 'service_id');
    }
}

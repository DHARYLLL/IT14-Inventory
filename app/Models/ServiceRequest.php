<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $table = 'services_requests';
    protected $fillable = [
        'dec_name',
        'svc_amount',
        'pkg_id',
        'prep_id'
    ];

    public function svcReqToPac() {
        return $this->belongsTo(Package::class, 'pkg_id');
    }

}

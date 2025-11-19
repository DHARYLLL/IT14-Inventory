<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class jobOrderDetails extends Model
{
    protected $table = 'job_ord_details';
    protected $fillable = [
        'dec_name',
        'dec_born_date',
        'dec_died_date',
        'dec_cause_of_death',
        'jod_startDate',
        'jod_endDate',
        'jod_wakeLoc',
        'jod_burialLoc',
        'jod_eq_stat',
        'jod_deploy_date',
        'jod_return_date',
        'pkg_id',
        'chap_id'
    ];
}

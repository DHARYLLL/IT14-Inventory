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
        'jod_days_of_wake',
        'jod_burialLoc',
        'jod_eq_stat',
        'jod_deploy_date',
        'jod_return_date',
        'pkg_id',
        'chap_id'
    ];

    public function jodToPkg(){
        return $this->belongsTo(Package::class, 'pkg_id');
    }

    public function jodToChap(){
        return $this->belongsTo(Chapel::class, 'chap_id');
    }

    public function jodToAddWake(){
        return $this->hasOne(AddWake::class, 'jod_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BurialAssistance extends Model
{
    protected $table = 'burial_assistance';
    protected $fillable = [
        /*
        'civil_status',
        'religion',
        'address',
        'birthdate',
        'gender',
        'rel_to_the_dec',
        */
        'amount',
        'jo_id'
    ];

    public function burAsstToJo() {
        return $this->belongsTo(jobOrder::class, 'jo_id');
    }

    public function burAsstToBac() {
        return $this->hasOne(BAClientInfos::class, 'bur_asst_id');
    }

    public function burAsstToBam() {
        return $this->hasOne(BAMotherInfos::class, 'bur_asst_id');
    }

    public function burAsstToBaf() {
        return $this->hasOne(BAFatherInfos::class, 'bur_asst_id');
    }

    public function burAsstToBao() {
        return $this->hasOne(BAOtherInfos::class, 'bur_asst_id');
    }
}

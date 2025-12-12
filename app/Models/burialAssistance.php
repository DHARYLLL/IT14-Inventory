<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BurialAssistance extends Model
{
    protected $table = 'burial_assistance';
    protected $fillable = [
        'amount'
    ];

    
    public function burAsstToJo() {
        return $this->hasOne(jobOrder::class, 'ba_id');
    }
    
    public function burAsstToBac() {
        return $this->hasOne(BAClientInfos::class, 'ba_id');
    }

    public function burAsstToBam() {
        return $this->hasOne(BAMotherInfos::class, 'ba_id');
    }

    public function burAsstToBaf() {
        return $this->hasOne(BAFatherInfos::class, 'ba_id');
    }

    public function burAsstToBao() {
        return $this->hasOne(BAOtherInfos::class, 'ba_id');
    }
}

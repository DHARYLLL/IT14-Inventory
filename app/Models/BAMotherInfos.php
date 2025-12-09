<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BAMotherInfos extends Model
{
    protected $table = 'ba_mother_infos';
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'civil_status',
        'religion',
        'bur_asst_id'
    ];

    public function bamToBurAsst() {
        return $this->belongsTo(BurialAssistance::class, 'bur_asst_id');
    }
}

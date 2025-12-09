<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BAFatherInfos extends Model
{
    protected $table = 'ba_father_infos';
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'civil_status',
        'religion',
        'bur_asst_id'
    ];

    public function bafToBurAsst() {
        return $this->belongsTo(BurialAssistance::class, 'bur_asst_id');
    }
}

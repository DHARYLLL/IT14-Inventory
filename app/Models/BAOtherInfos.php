<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BAOtherInfos extends Model
{
    protected $table = 'ba_other_infos';
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'civil_status',
        'religion',
        'relationship',
        'ba_id'
    ];

    public function baoToBurAsst() {
        return $this->belongsTo(BurialAssistance::class, 'ba_id');
    }
}

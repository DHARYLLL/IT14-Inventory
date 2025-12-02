<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BAClientInfos extends Model
{
    protected $table = 'ba_client_infos';
    protected $fillable = [
        'cli_fname',
        'cli_mname',
        'cli_lname',
        'civil_status',
        'religion',
        'address',
        'birthdate',
        'gender',
        'rel_to_the_dec',
        'bur_asst_id'
    ];

    public function bacToBurAsst() {
        return $this->belongsTo(BurialAssistance::class, 'bur_asst_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class addEquipment extends Model
{
    protected $table = 'add_equipment';
    protected $fillable = [
        'jod_id',
        'eq_id',
        'eq_dpl',
        'eq_add_fee'
    ];

    public function addEqToEq(){
        return $this->belongsTo(Equipment::class, 'eq_id');
    }
}

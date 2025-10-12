<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';
    protected $fillable = [
        'eq_name',
        'eq_type',
        'eq_available',
        'eq_size_weight',
        'eq_unit_price',
        'eq_in_use'
    ];

    public function eqToSvcEq(){
        return $this->hasMany(SvsEquipment::class, 'equipment_id');
    }
}

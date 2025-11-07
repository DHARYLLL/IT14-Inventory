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
        'eq_size',
        'eq_unit',
        'eq_unit_price',
        'eq_in_use'
    ];

    public function eqToPkgEq(){
        return $this->hasMany(PkgEquipment::class, 'eq_id');
    }
}

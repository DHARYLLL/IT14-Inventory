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
        'eq_net_content',
        'eq_size',
        'eq_in_use',
        'eq_low_limit',
        'archived'
    ];

    public function eqToPkgEq(){
        return $this->hasMany(PkgEquipment::class, 'eq_id');
    }
}

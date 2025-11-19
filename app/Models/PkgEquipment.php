<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PkgEquipment extends Model
{
    protected $table = 'pkg_equipment';
    protected $fillable = [
        'pkg_id',
        'eq_id',
        'prep_id',
        'eq_used'
    ];

    public function pkgEqToPkg() {
        return $this->belongsTo(Package::class, 'pkg_id');
    }

    public function pkgEqToEq() {
        return $this->belongsTo(Equipment::class, 'eq_id');
    }
}

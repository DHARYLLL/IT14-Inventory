<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stockOut extends Model
{
    protected $table = 'stock_outs';
    protected $fillable = [
        'reason',
        'so_date',
        'emp_id'
    ];

    public function soToSoi() {
        return $this->hasMany(StoOutItems::class, 'so_id');
    }

    public function soToSoe() {
        return $this->hasMany(StoOutEquipment::class, 'so_id');
    }

    public function soToEmp() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}

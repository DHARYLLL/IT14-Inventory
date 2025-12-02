<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoOutEquipment extends Model
{
    protected $table = 'sto_out_equipment';
    protected $fillable = [
        'so_id',
        'eq_id',
        'so_qty'
    ];

    public function soeToEq (){
        return $this->belongsTo(Equipment::class, 'eq_id');
    }
}

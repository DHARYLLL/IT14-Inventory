<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class addEquipment extends Model
{
    protected $table = 'add_equipment';
    protected $fillable = [
        'pkg_id',
        'eq_id',
        'eq_dpl'
    ];
}

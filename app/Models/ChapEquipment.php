<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChapEquipment extends Model
{
    protected $table = 'chapel_equipment';
    protected $fillable = [
        'chap_id',
        'eq_id',
        'eq_used'
    ];
}

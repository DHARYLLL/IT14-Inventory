<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TempEquipment extends Model
{
    protected $table = 'temp_eq_dpl';
    protected $fillable = [
        'jod_id',
        'pkg_eq_id',
        'eq_dpl_qty'
    ];

    public function tempEqToPkgEq() {
        return $this->BelongsTo(PkgEquipment::class, 'pkg_eq_id');
    }
}

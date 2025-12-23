<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class embalming extends Model
{
    protected $table = 'embalming';
    protected $fillable = [
        'embalmer_name',
        'prep_price',
        'archived'
    ];

    public function embToPkgSto(){
        return $this->hasMany(PkgStock::class, 'prep_id');
    }

    public function embToPkgEq(){
        return $this->hasMany(PkgEquipment::class, 'prep_id');
    }
}

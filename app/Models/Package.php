<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';
    protected $fillable = [
        'pkg_name',
        'pkg_price'
    ];

    public function pkgToPkgEq()
    {
        return $this->hasMany(PkgEquipment::class, 'pkg_id');
    }

    public function pkgToPkgSto()
    {
        return $this->hasMany(PkgStock::class, 'pkg_id');
    }

    public function pkgToJod()
    {
        return $this->hasMany(jobOrderDetails::class, 'pkg_id');
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';
    protected $fillable = [
        'pkg_name',
        'pkg_inclusion'
    ];

    public function pacToSvcReq(){
        return $this->hasMany(ServiceRequest::class, 'package_id');
    }

    public function pkgToPkgInc(){
        return $this->hasMany(packageInclusion::class , 'package_id');
    }
}

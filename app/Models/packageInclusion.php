<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class packageInclusion extends Model
{
    protected $table = 'package_inclusions';
    protected $fillable = [
        'pkg_inclusion',
        'package_id'
    ];

    public function pkgIncToPkg(){
        return $this->belongsTo(Package::class, 'package_id');
    }
}

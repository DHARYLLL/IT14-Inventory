<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PkgStock extends Model
{
    protected $table = 'pkg_stock';
    protected $fillable = [
        'pkg_id',
        'stock_id',
        'prep_id',
        'stock_used',
        'stock_used_set'
    ];

    public function pkgStoToPgk(){
        return $this->belongsTo(Package::class, 'pkg_id');
    }

    public function pkgStoToSto(){
        return $this->belongsTo(Stock::class, 'stock_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SvsStock extends Model
{
    protected $table = 'svs_stocks';
    protected $fillable = [
        'stock_id',
        'service_id',
        'stock_used'
    ];

    public function svcStoToSvcReq(){
        return $this->belongsTo(ServiceRequest::class, 'service_id');
    }

    public function svcStoToSto(){
        return $this->belongsTo(Stock::class, 'stock_id');
    }
}

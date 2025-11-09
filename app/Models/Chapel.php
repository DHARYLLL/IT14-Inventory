<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapel extends Model
{
    protected $table = 'chapels';
    protected $fillable = [
        'chap_name',
        'chap_room',
        'chap_price',
        'chap_status',
        'max_cap',
    ];

    public function chapToSvcReq() {
        return $this->hasOne(Receipt::class, 'chap_id');
    }
}

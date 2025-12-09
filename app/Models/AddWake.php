<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddWake extends Model
{
    protected $table = 'add_wake';
    protected $fillable = [
        'day',
        'fee',
        'jod_id'
    ];

    public function addwakeTojod(){
        return $this->belongsTo(JobOrderDetails::class, 'jod_id');
    }
}

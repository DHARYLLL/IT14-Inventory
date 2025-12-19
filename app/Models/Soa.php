<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soa extends Model
{
    protected $table = 'soa'; 
    protected $fillable = [
        'payment',
        'payment_date',
        'jo_id',
        'emp_id'
    ];

    public function soaToJo() {
        return $this->belongsTo(jobOrder::class , 'jo_id');
    }

    public function soaToEmp() {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}

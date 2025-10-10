<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = [
        'action',
        'from',
        'action_date',
        'emp_id'
    ];

    public function logToEmp(){
        return $this->belongsTo(Employee::class, 'emp_id');
    }
}

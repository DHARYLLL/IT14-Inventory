<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = [
        'emp_fname',
        'emp_mname',
        'emp_lname',
        'emp_contact_number',
        'emp_address',
        'emp_email',
        'emp_password',
        'emp_role'
    ];

    public function empToPo(){
        return $this->hasMany(PurchaseOrder::class, 'emp_id');
    }

    public function empToSvcReq(){
        return $this->hasMany(ServiceRequest::class, 'emp_id');
    }

    public function empToLog(){
        return $this->hasMany(Log::class, 'emp_id');
    }

}

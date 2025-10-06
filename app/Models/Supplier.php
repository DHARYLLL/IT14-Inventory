<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'contact_number',
        'company_name',
        'company_address'
    ];
}

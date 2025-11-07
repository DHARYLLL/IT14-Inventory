<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChapInclusion extends Model
{
    protected $table = 'chapel_inclusions';
    protected $fillable = [
        'chap_incl_name',
        'chap_id'
    ];
}
